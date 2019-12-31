<?php

namespace App\Http\Controllers;

use App\Model\EntradaEstoque;
use App\Model\Produto;
use App\Model\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntradaEstoqueController extends Controller
{
    private $produto;
    private $unidade_medida;
    private $entrada_estoque;

    function __construct(Produto $produto, UnidadeMedida $unidadeMedida, EntradaEstoque $entradaEstoque)
    {
        $this->middleware('auth');
        $this->produto = $produto;
        $this->unidade_medida = $unidadeMedida;
        $this->entrada_estoque = $entradaEstoque;

    }

    public function show()
    {
        /*
        echo '<pre>';
        var_dump($this->produto);
        exit;
        */
        $entradaEstoque = $this->entrada_estoque->all();
        $count = $entradaEstoque->count();

        foreach ($entradaEstoque as $key => $value):
            $value->setAttribute('unidade_medida', $this->getUnidadeMedida($value->unidade_medida_id));
            $value->setAttribute('produto', $this->getProduto($value->produto_id));
            $value->setAttribute('val_total', 'R$ ' . number_format($value->quantidade * $value->val_unitario, 2, ',', '.'));
        endforeach;


        return view('entrada-estoque.show', compact('entradaEstoque', 'count'));
    }

    public function getUnidadeMedida($id)
    {
        $unidade_medida = $this->unidade_medida->all();
        $descricao = '';
        foreach ($unidade_medida as $key => $value):
            if ($id == $value->id):
                $descricao = $value->sigla;
            endif;
        endforeach;

        return $descricao;
    }

    public function getProduto($id)
    {
        $produtos = $this->produto->all();
        $descricao = '';
        foreach ($produtos as $key => $value):
            if ($id == $value->id):
                $descricao = $value->descricao;
            endif;
        endforeach;

        return $descricao;
    }

    public function create()
    {
        $unidade_medida = $this->unidade_medida->all();
        $produto = $this->produto->all();
        return view('entrada-estoque.create', compact('unidade_medida', 'produto'));
    }

    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'produto_id' => 'required',
            'val_unitario' => 'required',
            'quantidade' => 'required',
            'unidade_medida_id' => 'required|numeric'
        ]);

        if ($validador->fails()) :
            return redirect()->route('entrada-estoque.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->entrada_estoque->unidade_medida_id = $request->input('unidade_medida_id');
            $this->entrada_estoque->produto_id = $request->input('produto_id');
            $this->entrada_estoque->quantidade = $request->input('quantidade');
            $this->entrada_estoque->val_unitario = $request->input('val_unitario');
            $this->entrada_estoque->num_nota_fiscal = $request->input('num_nota_fiscal') ? $request->input('num_nota_fiscal') : 0;

            $entradaEstoque_ins = $this->entrada_estoque->save();
            if ($entradaEstoque_ins) :
                return redirect()->route('entrada-estoque.show')
                    ->withInput()
                    ->with(['inser' => true, 'produto' => $this->getProduto($this->entrada_estoque->produto_id) ]);
            endif;
        endif;

        return redirect()->route('entrada-estoque.show')
            ->withInput()
            ->with(['error' => true, 'entrada-estoque' => 'Erro ao inserir o produto']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $produto = $this->produto->find($id);

        if ($produto->delete()) :
            return redirect()->route('produto.show')
                ->withInput()
                ->with(['delete' => true, 'produto' => $produto->descricao]);
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
        $produto = $this->produto->find($id);
        $unidade_medida = $this->unidade_medida->all();

        if (empty($produto)) :
            return "Aconteceu um erro";
        endif;

        return view('produto.edit', compact('produto', 'unidade_medida'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(Request $request)
    {
        $produto = $this->produto->find($request->input('id'));

        $validador = Validator::make($request->all(), [
            'descricao' => 'required',
            'unidade_medida_id' => 'required|numeric'
        ]);

        if ($validador->fails()) :
            return redirect()->to($this->getRedirectUrl())
                ->withErrors($validador)
                ->withInput($request->all());
        else :

            $produto->unidade_medida_id = $request->input('unidade_medida_id');
            $produto->descricao = $request->input('descricao');
            $produto->qtd_minimo = $request->input('qtd_minimo') ? $request->input('qtd_minimo') : 0;
            $produto->val_unitario = $request->input('val_unitario') ? $request->input('val_unitario') : 0;

            $produto_upt = $produto->save();
            if ($produto_upt) :
                return redirect()->route('produto.show')
                    ->withInput()
                    ->with(['update' => true, 'produto' => $produto->descricao]);
            endif;
        endif;

        return redirect()->route('produto.show')
            ->withInput()
            ->with(['error' => true, 'produto' => 'Erro ao atualizar a conta']);
    }

}
