<?php

namespace App\Http\Controllers;

use App\Model\MovimentacaoBancaria;
use Illuminate\Http\Request;
use App\Model\Boleto;
use App\Model\Pagamento;
use Illuminate\Support\Facades\Validator;

class BoletoController extends Controller
{
    private $pagamento;
    private $boleto;
    private $movimentacaoBancaria;

    public function __construct(Pagamento $pagamento, Boleto $boleto, MovimentacaoBancaria $movimentacaoBancaria)
    {
        $this->middleware('auth');
        $this->pagamento = $pagamento;
        $this->boleto = $boleto;
        $this->movimentacaoBancaria = $movimentacaoBancaria;
    }

    public function show()
    {
        $boletos = $this->boleto->with('pagamento')->get();
        $count = $boletos->count();

        return view('boleto.show', compact('boletos', 'count'));
    }

    public function create()
    {
        return view('boleto.create');
    }

    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'valor' => 'required|numeric',
            'data' => 'required|date',
            'des' => 'required|string|max:255',
            'nf' => 'required|numeric',
        ]);

        if ($validador->fails()):
            return redirect()->route('boleto.create')
                ->withErrors($validador)
                ->withInput();
        else:
            $boleto_ins = Pagamento::create([
                'vencimento' => $res->input('data'),
                'administrador_id' => auth()->id(),
                'descricao' => $res->input('des'),
                'valor' => $res->input('valor')
            ])->boleto()->create(['NF' => $res->input('nf')]);

            if ($boleto_ins):
                return redirect()->route('boleto.show')
                    ->withInput()
                    ->with(['inser' => true, 'boleto' => $res->input('nf')]);
            endif;
        endif;

        return redirect()->route('boleto.show')
            ->withInput()
            ->with(['error' => true, 'boleto' => 'Erro ao inserir o boleto']);
    }

    public function delete($id)
    {
        $boleto = $this->boleto->find($id);

        if ($boleto->delete()) :
            return redirect()->route('boleto.show')
                ->withInput()
                ->with(['delete' => true, 'boleto' => $boleto->NF]);
        endif;

        return redirect()->route('boleto.show')
            ->withInput()
            ->with(['error' => true, 'boleto' => 'Erro ao excluir o boleto']);
    }

    public function edit($id)
    {
        $boleto = $this->boleto->find($id);
        $pagamento = $this->pagamento->find($boleto->pagamento_id);
        $movimentacaoBancaria = $this->movimentacaoBancaria->find($boleto->movimentacao_bancaria_id);

        /*
        echo '<pre>';
        var_dump($pagamento);
        exit;
        */
        if (empty($boleto)) :
            return "Aconteceu um erro";
        endif;

        return view('boleto.edit', compact('boleto', 'pagamento', 'movimentacaoBancaria'));
    }

    public function update(Request $request)
    {
        $boleto = $this->boleto->find($request->input('id'));
        $pagamento = $this->pagamento->find($boleto->pagamento_id);
        $movimentacaoBancaria = $this->movimentacaoBancaria->find($boleto->movimentacao_bancaria_id);

        $validador = Validator::make($request->all(), [
            'valor' => 'required|numeric',
            'data' => 'required|date',
            'des' => 'required|string|max:255',
            'nf' => 'required|numeric',
        ]);

        if ($validador->fails()):
            return redirect()->to($this->getRedirectUrl())
                ->withErrors($validador)
                ->withInput($request->all());
        else:
            $pagamento->vencimento = $request->input('data');
            $pagamento->administrador_id = auth()->id();
            $pagamento->descricao = $request->input('des');
            $pagamento->valor = $request->input('valor');
            $boleto->NF = $request->input('nf');

            if ($pagamento->save() && $boleto->save()):
                return redirect()->route('boleto.show')
                    ->withInput()
                    ->with(['update' => true, 'boleto' => $request->input('nf')]);
            endif;
        endif;

        return redirect()->route('boleto.show')
            ->withInput()
            ->with(['error' => true, 'boleto' => 'Erro ao inserir o boleto']);
    }

}
