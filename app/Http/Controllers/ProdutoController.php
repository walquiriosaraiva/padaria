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

        foreach ($produtos as $chaveProduto => $descricaoProduto):
            $descricaoProduto->setAttribute('unidade_medida', $this->getUnidadeMedida($descricaoProduto->unidade_medida_id));
        endforeach;

        return view('produto.show', compact('produtos', 'count'));
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

    public function create()
    {
        $unidade_medida = $this->unidade_medida->all();
        return view('produto.create', compact('unidade_medida'));
    }

    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'descricao' => 'required',
            'unidade_medida_id' => 'required|numeric'
        ]);

        if ($validador->fails()) :
            return redirect()->route('produto.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->produto->unidade_medida_id = $request->input('unidade_medida_id');
            $this->produto->descricao = $request->input('descricao');
            $this->produto->qtd_minimo = $request->input('qtd_minimo') ? $request->input('qtd_minimo') : 0;
            $this->produto->val_unitario = $request->input('val_unitario') ? $request->input('val_unitario') : 0;

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
