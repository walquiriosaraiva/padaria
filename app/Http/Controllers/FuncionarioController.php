<?php

namespace App\Http\Controllers;

use App\Model\Cargo;
use App\Model\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuncionarioController extends Controller
{
    private $func;
    private $cargo;

    public function __construct(Funcionario $func, Cargo $cargo)
    {
        $this->middleware('auth');
        $this->func = $func;
        $this->cargo = $cargo;
    }

    public function edit($id)
    {
        $funcio = $this->func->find($id);
        /*
        echo '<pre>';
        var_dump($funcio);
        exit;
        */

        $cargos = $this->cargo->all();

        if (empty($funcio)) :
            return "Aconteceu um erro";
        endif;

        return view('funcionario.edit', compact('funcio', 'cargos'));
    }

    public function update(Request $req)
    {
        $funcionario = $this->func->find($req->input('id'));

        if (!empty($req->input('func'))) :
            $validador = Validator::make($req->all(), [
                'func' => 'required|string|max:255',
            ]);
        endif;

        if ($validador->fails()) :
            return redirect()->route('funcionario.edit')
                ->withErrors($validador)
                ->withInput();
        else :
            if (empty($req->input('func')) and ($funcionario->cargo_id != $req->input('cargo'))) :
                $funcionario->cargo_id = $req->input('cargo');
            elseif (!empty($req->input('func')) and ($funcionario->cargo_id == $req->input('cargo'))) :
                $funcionario->nome = $req->input('func');
            elseif (!empty($req->input('func')) and ($funcionario->cargo_id != $req->input('cargo'))) :
                $funcionario->nome = $req->input('func');
                $funcionario->cargo_id = $req->input('cargo');
            endif;

            $func_upd = $funcionario->save();

            if ($func_upd) :
                return redirect()->route('funcionario.show')->withInput()
                    ->with('update', true);
            endif;
        endif;

        return redirect()->route('funcionario.show')
            ->withInput()
            ->with(['error' => true, 'funcionario' => 'Erro ao atualizar o funcionário']);
    }

    public function delete($id)
    {
        $funcionario = $this->func->find($id);

        if ($funcionario->delete()) :
            return redirect()->route('funcionario.show')
                ->withInput()
                ->with(['delete' => true, 'nome' => $funcionario->nome]);
        endif;

        return redirect()->route('funcionario.show')
            ->withInput()
            ->with(['error' => true, 'funcionario' => 'Erro ao excluir o funcionário']);
    }

    public function show()
    {
        $funcio = $this->func->with('cargo')->get();
        $count = $funcio->count();

        return view('funcionario.show', compact('funcio', 'count'));
    }

    public function create()
    {
        $cargos = $this->cargo->all();
        return view('funcionario.create', compact('cargos'));
    }

    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'func' => 'required|string',
            'cargo' => 'required|numeric|min:1'
        ]);

        if ($validador->fails()) :
            return redirect()->route('funcionario.create')
                ->withErrors($validador)
                ->withInput();
        else :
            $this->func->nome = $res->input('func');
            $this->func->administrador_id = auth()->id();
            $cargo = $this->cargo->find($res->input('cargo'));
            $cargo_ins = $cargo->funcionarios()->save($this->func);

            if ($cargo_ins) :
                return redirect()->route('funcionario.show')
                    ->withInput()
                    ->with('inser', true);
            endif;
        endif;

        return redirect()->route('funcionario.show')
            ->withInput()
            ->with(['error' => true, 'funcionario' => 'Erro ao inserir o funcionário']);
    }

}
