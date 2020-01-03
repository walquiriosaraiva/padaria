<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    private $admin;

    public function __construct(User $admin)
    {
        $this->middleware('auth');
        $this->admin = $admin;
    }

    public function index()
    {
        $admin = DB::table('administrador')->find(Auth::id());
        return view('admin.index', compact('admin'));
    }

    public function edit()
    {
        $admin = $this->admin->find(Auth::id());
        if (empty($admin)) :
            return redirect()->route('admin.index')
                ->withInput()
                ->with(['error' => true, 'admin' => 'Erro ao editar usuário']);
        endif;

        return view('admin.edit', compact('admin'));
    }

    public function update(Request $req)
    {
        $id = Auth::id();
        $admin = $this->admin->find($id);

        if (empty($req->input('senha')) and ($admin->email != $req->input('email'))) :
            $validador = Validator::make($req->all(), [
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:160|unique:users',
            ]);
        elseif (empty($req->input('senha') and ($admin->email == $req->input('email')))) :
            $validador = Validator::make($req->all(), [
                'nome' => 'required|string|max:255',
            ]);
        elseif (!empty($req->input('senha') and ($admin->email == $req->input('email')))) :
            $validador = Validator::make($req->all(), [
                'nome' => 'required|string|max:255',
                'senha' => 'string|min:6|confirmed',
            ]);
        else :
            $validador = Validator::make($req->all(), [
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:160|unique:users',
                'senha' => 'string|min:6|confirmed',
            ]);
        endif;

        if ($validador->fails()) :
            return redirect()->route('admin.edit')
                ->withErrors($validador)
                ->withInput();
        else :
            if (empty($req->input('senha') and ($admin->email != $req->input('email')))) :
                $admin->name = $req->input('nome');
                $admin->email = $req->input('email');
            elseif (empty($req->input('senha') and ($admin->email == $req->input('email')))) :
                $admin->name = $req->input('nome');
            elseif (!empty($req->input('senha') and ($admin->email == $req->input('email')))) :
                $admin->name = $req->input('nome');
                $admin->password = bcrypt($req->input('senha'));;
            else :
                $admin->name = $req->input('nome');
                $admin->email = $req->input('email');
                $admin->password = bcrypt($req->input('senha'));
            endif;
            $admin_upd = $admin->save();

            if ($admin_upd) :
                return redirect()->route('admin');
            endif;
        endif;

        return redirect()->route('admin.index')
            ->withInput()
            ->with(['error' => true, 'admin' => 'Erro ao atualizar usuário']);
    }
}
