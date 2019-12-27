<?php

namespace App\Http\Controllers;

use App\Model\Produto;
use App\Model\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    private $produto;
    private $unidade_medida;

    function __construct(Produto $produto, UnidadeMedida $unidadeMedida)
    {
        $this->middleware('auth');
        $this->produto = $produto;
        $this->unidade_medida = $unidadeMedida;
    }

    public function show()
    {
        /*
        echo '<pre>';
        var_dump($this->produto);
        exit;
        */
        $produtos = $this->produto->all();
        $count = $produtos->count();

        return view('produto.show', compact('produtos', 'count'));
    }

    public function create()
    {
        $unidade_medida = $this->unidade_medida->all();
        return view('produto.create', compact('unidade_medida'));
    }

    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'descricao' => 'required',
            'qtd_minimo' => 'required|numeric|min:1',
            'unidade_medida_id' => 'required|numeric',
            'val_unitario' => 'required|numeric',
        ]);

        if ($validador->fails()) :
            return redirect()->route('produto.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->produto->unidade_medida_id = $request->input('unidade_medida_id');
            $this->produto->descricao = $request->input('descricao');
            $this->produto->qtd_minimo = $request->input('qtd_minimo');
            $this->produto->val_unitario = $request->input('val_unitario');

            $produto_ins = $this->produto->save();
            if ($produto_ins) :
                return redirect()->route('produto.show')
                    ->withInput()
                    ->with(['inser' => true, 'produto' => $this->produto->descricao]);
            endif;
        endif;

        return redirect()->route('produto.show')
            ->withInput()
            ->with(['error' => true, 'produto' => 'Erro ao inserir o produto']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $conta = $this->conta->find($id);

        if ($conta->delete()) :
            return redirect()->route('produto.show')
                ->withInput()
                ->with(['delete' => true, 'produto' => $conta->numero, 'banco' => $conta->banco]);
        endif;

        return redirect()->route('produto.show')
            ->withInput()
            ->with(['error' => true, 'produto' => 'Erro ao excluir a conta']);
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

        return view('produto.edit', compact('conta', 'bancos'));
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
                return redirect()->route('produto.show')
                    ->withInput()
                    ->with(['update' => true, 'produto' => $conta->Numero, 'banco' => $conta->Banco]);
            endif;
        endif;

        return redirect()->route('produto.show')
            ->withInput()
            ->with(['error' => true, 'produto' => 'Erro ao atualizar a conta']);
    }

}
