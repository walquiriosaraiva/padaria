<?php

namespace App\Http\Controllers;

use App\Model\Folga;
use App\Model\Funcionario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FolgaController extends Controller
{
    private $folga;
    private $func;

    public function __construct(Folga $folga, Funcionario $funcionario)
    {
        $this->middleware('auth');
        $this->folga = $folga;
        $this->func = $funcionario;
    }

    public function show()
    {
        $folgas = $this->folga->with('funcionario')->get();
        $count = $folgas->count();

        return view('folga.show', compact('folgas', 'count'));
    }

    public function create()
    {
        $funcionarios = $this->func->all();
        return view('folga.create', compact('funcionarios'));
    }

    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'data' => 'required|date',
            'turno' => 'required|numeric|min:0',
            'func' => 'required|numeric|min:1',
        ]);

        if ($validador->fails()):
            return redirect()->route('folga.create')
                ->withErrors($validador)
                ->withInput();
        else:
            $funcionario = $this->func->find($res->input('func'));

            if ($res->input('turno') == 0):
                $this->folga->Turno = 'M';
            elseif ($res->input('turno') == 1):
                $this->folga->Turno = 'T';
            else:
                $this->folga->Turno = 'N';
            endif;
            $this->folga->Dia = $res->input('data');

            $folga_ins = $funcionario->folgas()->save($this->folga);
            if ($folga_ins):
                return redirect()->route('folga.show')
                    ->withInput()
                    ->with(['inser' => true, 'nome' => $funcionario->nome]);
            endif;
        endif;

        return redirect()->route('folga.show')
            ->withInput()
            ->with(['error' => true, 'folga' => 'Erro ao inserir a folga do funcionário']);
    }

    public function edit($id)
    {
        $folga = $this->folga->find($id);
        $funcionarios = $this->func->all();

        if (empty($folga)) :
            return "Aconteceu um erro";
        endif;

        return view('folga.edit', compact('funcionarios', 'folga'));
    }

    public function update(Request $request)
    {
        $folga = $this->folga->find($request->input('id'));
        $funcionario = $this->func->find($folga->funcionario_id);

        $validador = Validator::make($request->all(), [
            'data' => 'required|date',
            'turno' => 'required|numeric|min:0',
            'func' => 'required|numeric|min:1',
        ]);

        if ($validador->fails()):
            return redirect()->route('folga.edit')
                ->withErrors($validador)
                ->withInput();
        else:
            if ($request->input('turno') == 1):
                $folga->Turno = 'M';
            elseif ($request->input('turno') == 2):
                $folga->Turno = 'T';
            else:
                $folga->Turno = 'N';
            endif;
            $folga->Dia = $request->input('data');

            $folga_upt = $folga->save();
            if ($folga_upt):
                return redirect()->route('folga.show')
                    ->withInput()
                    ->with(['update' => true, 'nome' => $funcionario->nome]);
            endif;
        endif;

        return redirect()->route('folga.show')
            ->withInput()
            ->with(['error' => true, 'folga' => 'Erro ao atualizar a folga do funcionário']);
    }

    public function delete($id)
    {
        $folga = $this->folga->find($id);
        $funcionario = $this->func->find($folga->funcionario_id);

        if ($folga->delete()) :
            return redirect()->route('folga.show')
                ->withInput()
                ->with(['delete' => true, 'nome' => $funcionario->nome]);
        endif;

        return redirect()->route('folga.show')
            ->withInput()
            ->with(['error' => true, 'folga' => 'Erro ao excluir a folga do funcionário']);
    }
}
