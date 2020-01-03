<?php

namespace App\Http\Controllers;

use App\Model\Produto;
use App\Model\SaidaEstoque;
use App\Model\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaidaEstoqueController extends Controller
{
    private $produto;
    private $unidade_medida;
    private $saida_estoque;

    function __construct(Produto $produto, UnidadeMedida $unidadeMedida, SaidaEstoque $saidaEstoque)
    {
        $this->middleware('auth');
        $this->produto = $produto;
        $this->unidade_medida = $unidadeMedida;
        $this->saida_estoque = $saidaEstoque;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {

        $data = $request->all();
        if (isset($data['created_at']) && $data['created_at'] || isset($data['produto_id']) && $data['produto_id']):
            if (isset($data['created_at']) && $data['created_at'] && isset($data['produto_id']) && $data['produto_id']):
                $saidaEstoque = $this->saida_estoque->all()
                    ->where('created_at', '>=', $data['created_at'].' 00:00:00')
                    ->where('created_at', '<=', $data['created_at'].' 23:59:00')
                    ->where('produto_id', '=', $data['produto_id'])
                    ->sortBy("produto_id");
            elseif(isset($data['created_at']) && $data['created_at'] && !isset($data['produto_id']) && !$data['produto_id']):
                $saidaEstoque = $this->saida_estoque->all()
                    ->where('created_at', '>=', $data['created_at'].' 00:00:00')
                    ->where('created_at', '<=', $data['created_at'].' 23:59:00')
                    ->sortBy("produto_id");
            elseif(!isset($data['created_at']) && !$data['created_at'] && isset($data['produto_id']) && $data['produto_id']):
                $saidaEstoque = $this->saida_estoque->all()
                    ->where('produto_id', '=', $data['produto_id'])
                    ->sortBy("produto_id");
            endif;
        else:
            $data['created_at'] = null;
            $data['produto_id'] = null;
            $saidaEstoque = $this->saida_estoque->all()->sortBy("produto_id");
        endif;

        $count = $saidaEstoque->count();
        $qtdTotal = 0;
        $somaTotal = 0;
        foreach ($saidaEstoque as $key => $value):
            $value->setAttribute('unidade_medida', $this->getUnidadeMedida($value->unidade_medida_id));
            $value->setAttribute('produto', $this->getProduto($value->produto_id));
            $value->setAttribute('val_total', number_format($value->quantidade * $value->val_unitario, 2, ',', '.'));
            $qtdTotal += $value->quantidade;
            $somaTotal += $value->quantidade * $value->val_unitario;
        endforeach;
        $saidaEstoque->quantidade_total = $qtdTotal;
        $saidaEstoque->soma_total = number_format($somaTotal, 2, ',', '.');

        $produto = $this->produto->all();
        return view('saida-estoque.show', compact('saidaEstoque', 'count', 'produto', 'data'));
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
     * @param $id
     * @return mixed|string
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $unidade_medida = $this->unidade_medida->all();
        $produto = $this->produto->all();
        return view('saida-estoque.create', compact('unidade_medida', 'produto'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'produto_id' => 'required',
            'val_unitario' => 'required',
            'quantidade' => 'required',
            'unidade_medida_id' => 'required|numeric'
        ]);

        if ($validador->fails()) :
            return redirect()->route('saida-estoque.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->saida_estoque->unidade_medida_id = $request->input('unidade_medida_id');
            $this->saida_estoque->produto_id = $request->input('produto_id');
            $this->saida_estoque->quantidade = $request->input('quantidade');
            $this->saida_estoque->val_unitario = $request->input('val_unitario');
            $this->saida_estoque->num_cupom = $request->input('num_cupom') ? $request->input('num_cupom') : 0;

            $saidaEstoque_ins = $this->saida_estoque->save();
            if ($saidaEstoque_ins) :
                return redirect()->route('saida-estoque.show')
                    ->withInput()
                    ->with(['inser' => true, 'produto' => $this->getProduto($this->saida_estoque->produto_id)]);
            endif;
        endif;

        return redirect()->route('saida-estoque.show')
            ->withInput()
            ->with(['error' => true, 'saida-estoque' => 'Erro ao inserir o produto']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $saidaEstoque = $this->saida_estoque->find($id);

        if ($saidaEstoque->delete()) :
            return redirect()->route('saida-estoque.show')
                ->withInput()
                ->with(['delete' => true, 'produto' => $this->getProduto($saidaEstoque->produto_id)]);
        endif;

        return redirect()->route('saida-estoque.show')
            ->withInput()
            ->with(['error' => true, 'produto' => 'Erro ao excluir a saída de estoque']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {
        $saidaEstoque = $this->saida_estoque->find($id);
        $unidade_medida = $this->unidade_medida->all();
        $produto = $this->produto->all();

        if (empty($saidaEstoque)) :
            return "Aconteceu um erro";
        endif;

        return view('saida-estoque.edit', compact('produto', 'unidade_medida', 'saidaEstoque'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(Request $request)
    {
        $saidaEstoque = $this->saida_estoque->find($request->input('id'));

        $validador = Validator::make($request->all(), [
            'produto_id' => 'required',
            'val_unitario' => 'required',
            'quantidade' => 'required',
            'unidade_medida_id' => 'required|numeric'
        ]);

        if ($validador->fails()) :
            return redirect()->to($this->getRedirectUrl())
                ->withErrors($validador)
                ->withInput($request->all());
        else :

            $saidaEstoque->unidade_medida_id = $request->input('unidade_medida_id');
            $saidaEstoque->produto_id = $request->input('produto_id');
            $saidaEstoque->quantidade = $request->input('quantidade');
            $saidaEstoque->val_unitario = $request->input('val_unitario');
            $saidaEstoque->num_cupom = $request->input('num_cupom') ? $request->input('num_cupom') : 0;

            $saidaEstoque_upt = $saidaEstoque->save();
            if ($saidaEstoque_upt) :
                return redirect()->route('saida-estoque.show')
                    ->withInput()
                    ->with(['update' => true, 'produto' => $this->getProduto($saidaEstoque->produto_id)]);
            endif;
        endif;

        return redirect()->route('saida-estoque.show')
            ->withInput()
            ->with(['error' => true, 'produto' => 'Erro ao atualizar a saída estoque']);
    }

}
