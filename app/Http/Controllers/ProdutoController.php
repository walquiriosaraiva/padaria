<?php

namespace App\Http\Controllers;

use App\Model\EntradaEstoque;
use App\Model\Produto;
use App\Model\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    private $produto;
    private $unidade_medida;

    /**
     * ProdutoController constructor.
     * @param Produto $produto
     * @param UnidadeMedida $unidadeMedida
     */
    function __construct(Produto $produto, UnidadeMedida $unidadeMedida)
    {
        $this->middleware('auth');
        $this->produto = $produto;
        $this->unidade_medida = $unidadeMedida;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $produtos = $this->produto->all();
        $count = $produtos->count();
        $qtdTotal = 0;
        $somaTotal = 0;

        foreach ($produtos as $chaveProduto => $descricaoProduto):
            $descricaoProduto->setAttribute('unidade_medida', $this->getUnidadeMedida($descricaoProduto->unidade_medida_id));
            $descricaoProduto->setAttribute('saldo_estoque', $this->getSaldoEntradaEstoque($descricaoProduto->id) - $this->getSaldoSaidaEstoque($descricaoProduto->id));
            $descricaoProduto->setAttribute('unitario', number_format($this->getValUnitarioEntrada($descricaoProduto->id), 2, ',', '.'));
            $descricaoProduto->setAttribute('total', number_format($this->getValUnitarioEntrada($descricaoProduto->id) * ($this->getSaldoEntradaEstoque($descricaoProduto->id) - $this->getSaldoSaidaEstoque($descricaoProduto->id)), 2, ',', '.'));
            $qtdTotal += $this->getSaldoEntradaEstoque($descricaoProduto->id) - $this->getSaldoSaidaEstoque($descricaoProduto->id);
            $somaTotal += $this->getValUnitarioEntrada($descricaoProduto->id) * ($this->getSaldoEntradaEstoque($descricaoProduto->id) - $this->getSaldoSaidaEstoque($descricaoProduto->id));
        endforeach;
        $produtos->quantidade_total = $qtdTotal;
        $produtos->soma_total = number_format($somaTotal, 2, ',', '.');

        return view('produto.show', compact('produtos', 'count'));
    }

    /**
     * @param $produto_id
     * @return mixed
     */
    public function getValUnitarioEntrada($produto_id)
    {
        $entradaEstoque = DB::table('entrada_estoque')->where('produto_id', '=', $produto_id)->latest()->first();

        $valUnitario = 0;
        if (!empty($entradaEstoque) && $entradaEstoque->val_unitario > 0):
            $valUnitario = $entradaEstoque->val_unitario;
        endif;

        return $valUnitario;
    }

    /**
     * @param $produto_id
     * @return mixed
     */
    public function getValUnitarioSaida($produto_id)
    {
        $saidaEstoque = DB::table('saida_estoque')->where('produto_id', '=', $produto_id)->latest()->first();

        $valUnitario = 0;
        if (!empty($saidaEstoque) && $saidaEstoque->val_unitario > 0):
            $valUnitario = $saidaEstoque->val_unitario;
        endif;

        return $valUnitario;
    }

    /**
     * @param $produto_id
     * @return int
     */
    public function getSaldoEntradaEstoque($produto_id)
    {
        $entradaEstoque = DB::table('entrada_estoque')->where('produto_id', '=', $produto_id)->get();

        $quantidade = 0;
        foreach ($entradaEstoque as $key => $value):
            if ($value->produto_id == $produto_id):
                $quantidade += $value->quantidade;
            endif;
        endforeach;

        return $quantidade;
    }

    /**
     * @param $produto_id
     * @return int
     */
    public function getSaldoSaidaEstoque($produto_id)
    {
        $saidaEstoque = DB::table('saida_estoque')->where('produto_id', '=', $produto_id)->get();
        $quantidade = 0;
        foreach ($saidaEstoque as $key => $value):
            if ($value->produto_id == $produto_id):
                $quantidade += $value->quantidade;
            endif;
        endforeach;

        return $quantidade;
    }

    /**
     * @param $id
     * @return mixed|string
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $unidade_medida = $this->unidade_medida->all();
        return view('produto.create', compact('unidade_medida'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
            $this->produto->user_id = auth()->id();
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
     * @throws \Exception
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
            $produto->user_id = auth()->id();
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
