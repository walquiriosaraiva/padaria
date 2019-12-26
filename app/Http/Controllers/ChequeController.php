<?php

namespace App\Http\Controllers;

use App\Model\MovimentacaoBancaria;
use Illuminate\Http\Request;
use App\Model\Cheque;
use App\Model\Pagamento;
use Illuminate\Support\Facades\Validator;

class ChequeController extends Controller
{
    private $pagamento;
    private $cheque;
    private $movimentacaoBancaria;

    public function __construct(Pagamento $pagamento, Cheque $cheque, MovimentacaoBancaria $movimentacaoBancaria)
    {
        $this->middleware('auth');
        $this->pagamento = $pagamento;
        $this->cheque = $cheque;
        $this->movimentacaoBancaria = $movimentacaoBancaria;
    }

    public function show()
    {
        $cheques = $this->cheque->with('pagamento')->get();
        $count = $cheques->count();

        return view('cheque.show', compact('cheques', 'count'));
    }

    public function create()
    {
        return view('cheque.create');
    }

    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'valor' => 'required|numeric',
            'data' => 'required|date',
            'des' => 'required|string|max:255',
            'nc' => 'required|numeric',
        ]);

        if ($validador->fails()):
            return redirect()->route('cheque.create')
                ->withErrors($validador)
                ->withInput();
        else:
            $cheque_ins = Pagamento::create([
                'vencimento' => $res->input('data'),
                'administrador_id' => auth()->id(),
                'descricao' => $res->input('des'),
                'valor' => $res->input('valor')
            ])->cheque()->create(['numero' => $res->input('nc')]);

            if ($cheque_ins):
                return redirect()->route('cheque.show')
                    ->withInput()
                    ->with(['inser' => true, 'cheque' => $res->input('nc')]);
            endif;
        endif;

        return redirect()->route('cheque.show')
            ->withInput()
            ->with(['error' => true, 'cheque' => 'Erro ao inserir o cheque']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {
        $cheque = $this->cheque->find($id);
        $pagamento = $this->pagamento->find($cheque->pagamento_id);
        $movimentacaoBancaria = $this->movimentacaoBancaria->find($cheque->movimentacao_bancaria_id);

        if (empty($cheque)) :
            return "Aconteceu um erro";
        endif;

        return view('cheque.edit', compact('cheque', 'pagamento', 'movimentacaoBancaria'));
    }

    public function delete($id)
    {
        $conta = $this->cheque->find($id);

        if ($conta->delete()) :
            return redirect()->route('cheque.show')
                ->withInput()
                ->with(['delete' => true, 'cheque' => $conta->numero]);
        endif;

        return redirect()->route('cheque.show')
            ->withInput()
            ->with(['error' => true, 'cheque' => 'Erro ao excluir o cheque']);
    }

    public function update(Request $request)
    {
        $cheque = $this->cheque->find($request->input('id'));
        $pagamento = $this->pagamento->find($cheque->pagamento_id);
        $movimentacaoBancaria = $this->movimentacaoBancaria->find($cheque->movimentacao_bancaria_id);

        $validador = Validator::make($request->all(), [
            'valor' => 'required|numeric',
            'data' => 'required|date',
            'des' => 'required|string|max:255',
            'nc' => 'required|numeric',
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

            $cheque->numero = $request->input('nc');

            if ($pagamento->save() && $cheque->save()):
                return redirect()->route('cheque.show')
                    ->withInput()
                    ->with(['update' => true, 'cheque' => $cheque->numero]);
            endif;
        endif;

        return redirect()->route('cheque.show')
            ->withInput()
            ->with(['error' => true, 'cheque' => 'Erro ao atualizar o cheque']);
    }
}
