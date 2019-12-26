<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\FluxoDiario;
use Illuminate\Support\Facades\Validator;

class FluxoDiarioController extends Controller
{
    private $fd;

    function __construct(FluxoDiario $fd)
    {
        $this->middleware('auth');
        $this->fd = $fd;
    }

    public function show()
    {
        $fluxos = $this->fd->all();
        $count = $fluxos->count();

        return view('fluxo.show', compact('fluxos', 'count'));
    }

    public function create()
    {
        return view('fluxo.create');
    }

    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'cf' => 'required|numeric',
            'sd' => 'required|numeric',
            'redi' => 'required|numeric',
            'cartao' => 'required|numeric',
            'rd' => 'required|numeric',
            'rc' => 'required|numeric',
            'td' => 'required|numeric',
            'tg' => 'required|numeric',
            'dia' => 'unique:fluxo_diario'
        ]);

        if ($validador->fails()) :
            return redirect()->route('fluxo.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->fd->Cofre = $res->input('cf');
            $this->fd->Dia = $res->input('dia');
            $this->fd->Saldo = $res->input('sd');
            $this->fd->Cartao = $res->input('cartao');
            $this->fd->Rendimento = $res->input('redi');
            $this->fd->Retirada_dia = $res->input('rd');
            $this->fd->Retirada_cofre = $res->input('rc');
            $this->fd->Total_vendas = $res->input('td');
            $this->fd->Total_geral = $res->input('tg');
            $this->fd->administrador_id = auth()->id();

            $fd_ins = $this->fd->save();
            if ($fd_ins) :
                return redirect()->route('fluxo.show')
                    ->withInput()
                    ->with('inser', true);
            endif;
        endif;

        return redirect()->route('fluxo.show')
            ->withInput()
            ->with(['error' => true, 'fluxo' => 'Erro ao inserir o fluxo']);
    }

    public function edit($id)
    {
        $fluxo = $this->fd->find($id);

        if (empty($fluxo)) :
            return "Aconteceu um erro";
        endif;

        return view('fluxo.edit', compact('fluxo'));
    }

    public function update(Request $request)
    {
        $fluxo = $this->fd->find($request->input('id'));

        $validador = Validator::make($request->all(), [
            'cf' => 'required|numeric',
            'sd' => 'required|numeric',
            'redi' => 'required|numeric',
            'cartao' => 'required|numeric',
            'rd' => 'required|numeric',
            'rc' => 'required|numeric',
            'td' => 'required|numeric',
            'tg' => 'required|numeric'
        ]);

        if ($validador->fails()):
            return redirect()->to($this->getRedirectUrl())
                ->withErrors($validador)
                ->withInput($request->all());
        else:
            $fluxo->Cofre = $request->input('cf');
            $fluxo->Dia = $request->input('dia');
            $fluxo->Saldo = $request->input('sd');
            $fluxo->Cartao = $request->input('cartao');
            $fluxo->Rendimento = $request->input('redi');
            $fluxo->Retirada_dia = $request->input('rd');
            $fluxo->Retirada_cofre = $request->input('rc');
            $fluxo->Total_vendas = $request->input('td');
            $fluxo->Total_geral = $request->input('tg');
            $fluxo->administrador_id = auth()->id();


            $fluxo_upt = $fluxo->save();
            if ($fluxo_upt):
                return redirect()->route('fluxo.show')
                    ->withInput()
                    ->with('update', true);
            endif;
        endif;

        return redirect()->route('fluxo.show')
            ->withInput()
            ->with(['error' => true, 'fluxo' => 'Erro ao atualizar o fluxo']);
    }

    public function delete($id)
    {
        $fluxo = $this->fd->find($id);

        if ($fluxo->delete()) :
            return redirect()->route('fluxo.show')
                ->withInput()
                ->with('delete', true);
        endif;

        return redirect()->route('fluxo.show')
            ->withInput()
            ->with(['error' => true, 'fluxo' => 'Erro ao excluir o fluxo']);
    }
}
