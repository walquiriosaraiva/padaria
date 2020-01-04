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

    /**
     * AdministradorController constructor.
     * @param User $admin
     */
    public function __construct(User $admin)
    {
        $this->middleware('auth');
        $this->admin = $admin;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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

    /**
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $req)
    {
        $id = Auth::id();
        $admin = $this->admin->find($id);

        $validador = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:160'
        ]);

        if ($req->input('password')):
            $validador = Validator::make($req->all(), [
                'password' => 'required|string|min:6|confirmed'
            ]);
        endif;

        if ($validador->fails()) :
            return redirect()->route('admin.edit')
                ->withErrors($validador)
                ->withInput();
        else :

            $admin->name = $req->input('name');
            $admin->email = $req->input('email');
            if ($req->input('password')):
                $admin->password = bcrypt($req->input('password'));
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
