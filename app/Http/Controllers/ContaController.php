<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Conta;

class ContaController extends Controller
{
    private $conta;

    function __construct(Conta $con)
    {
        $this->middleware('auth');
        $this->conta = $con;
    }

    public function show()
    {
        $contas = $this->conta->all();
        $count = $contas->count();

        return view('conta.show', compact('contas', 'count'));
    }

    public function create()
    {
        $bancos = $this->bancos();
        return view('conta.create', compact('bancos'));
    }

    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'bc' => 'required|numeric|max:9|min:1',
            'ac' => 'required|numeric',
            'tc' => 'required|numeric|max:2|min:1',
            'nc' => 'required|numeric',
            'sc' => 'required|numeric',
        ]);

        if ($validador->fails()) :
            return redirect()->route('conta.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->conta->Banco = $this->banco($res->input('bc'));

            $this->conta->Agencia = $res->input('ac');
            $this->conta->Tipo = $res->input('tc');
            $this->conta->Numero = $res->input('nc');
            $this->conta->Saldo = $res->input('sc');
            $this->conta->administrador_id = auth()->id();

            $conta_ins = $this->conta->save();
            if ($conta_ins) :
                return redirect()->route('conta.show')
                    ->withInput()
                    ->with(['inser' => true, 'conta' => $this->conta->Numero, 'banco' => $this->conta->Banco]);
            endif;
        endif;

        return redirect()->route('conta.show')
            ->withInput()
            ->with(['error' => true, 'conta' => 'Erro ao inserir a conta']);
    }

    /**
     * @return array
     */
    public function bancos()
    {
        return array(
            1 => 'Banco do Brasil',
            2 => 'Banco Bradesco',
            3 => 'Caixa Econòmica',
            4 => 'Banco Itaú',
            5 => 'Banco BRB',
            6 => 'Banco HSBC'
        );
    }

    /**
     * @param $banco
     * @return mixed|string
     */
    public function banco($banco)
    {
        foreach ($this->bancos() as $key => $value):
            if ($banco == $key):
                return $value;
            endif;
        endforeach;

        return '';
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $conta = $this->conta->find($id);

        if ($conta->delete()) :
            return redirect()->route('conta.show')
                ->withInput()
                ->with(['delete' => true, 'conta' => $conta->numero, 'banco' => $conta->banco]);
        endif;

        return redirect()->route('conta.show')
            ->withInput()
            ->with(['error' => true, 'conta' => 'Erro ao excluir a conta']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {
        $conta = $this->conta->find($id);
        $bancos = $this->bancos();

        if (empty($conta)) :
            return "Aconteceu um erro";
        endif;

        return view('conta.edit', compact('conta', 'bancos'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(Request $request)
    {
        $conta = $this->conta->find($request->input('id'));

        $validador = Validator::make($request->all(), [
            'bc' => 'required|numeric|max:9|min:1',
            'ac' => 'required|numeric',
            'tc' => 'required|numeric|max:1|min:0',
            'nc' => 'required|numeric',
            'sc' => 'required|numeric',
        ]);

        if ($validador->fails()) :
            return redirect()->to($this->getRedirectUrl())
                ->withErrors($validador)
                ->withInput($request->all());
        else :
            $conta->Banco = $this->banco($request->input('bc'));

            $conta->Agencia = $request->input('ac');
            $conta->Tipo = $request->input('tc');
            $conta->Numero = $request->input('nc');
            $conta->Saldo = $request->input('sc');
            $conta->administrador_id = auth()->id();

            $conta_upt = $conta->save();
            if ($conta_upt) :
                return redirect()->route('conta.show')
                    ->withInput()
                    ->with(['update' => true, 'conta' => $conta->Numero, 'banco' => $conta->Banco]);
            endif;
        endif;

        return redirect()->route('conta.show')
            ->withInput()
            ->with(['error' => true, 'conta' => 'Erro ao atualizar a conta']);
    }

}
