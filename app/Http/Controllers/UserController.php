<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $users = $this->user->get();
        $count = $users->count();
        foreach($users as $key=>$value):
            if($value->perfil == 1):
                $value->setAttribute('des_perfil', 'Administrador');
            elseif($value->perfil == 2):
                $value->setAttribute('des_perfil', 'Gerente');
            else:
                $value->setAttribute('des_perfil', 'Atendente');
            endif;
        endforeach;

        return view('user.show', compact('users', 'count'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * @param Request $res
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $res)
    {
        $validador = Validator::make($res->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'perfil' => 'required',
        ]);

        if ($validador->fails()):
            return redirect()->route('user.create')
                ->withErrors($validador)
                ->withInput();
        else:
            $user_ins = User::create([
                'name' => $res->input('name'),
                'email' => $res->input('email'),
                'perfil' => $res->input('perfil'),
                'password' => bcrypt($res->input('password'))
            ]);

            if ($user_ins):
                return redirect()->route('user.show')
                    ->withInput()
                    ->with(['inser' => true, 'user' => $res->input('name')]);
            endif;
        endif;

        return redirect()->route('user.show')
            ->withInput()
            ->with(['error' => true, 'user' => 'Erro ao inserir o usuário']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) :
            return "Aconteceu um erro";
        endif;

        return view('user.edit', compact('user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $user = $this->user->find($id);

        if ($user->delete()) :
            return redirect()->route('user.show')
                ->withInput()
                ->with(['delete' => true, 'user' => $user->name]);
        endif;

        return redirect()->route('user.show')
            ->withInput()
            ->with(['error' => true, 'user' => 'Erro ao excluir o usuário']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = $this->user->find($request->input('id'));

        $validador = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'perfil' => 'required',
        ]);

        if($request->input('password') && $request->input('password_confirmation')):
            $validador = Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed'
            ]);
        endif;

        if ($validador->fails()):
            return redirect()->to($this->getRedirectUrl())
                ->withErrors($validador)
                ->withInput($request->all());
        else:
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->perfil = $request->input('perfil');
            if ($request->input('password')):
                $user->password = bcrypt($request->input('password'));
            endif;

            if ($user->save()):
                return redirect()->route('user.show')
                    ->withInput()
                    ->with(['update' => true, 'user' => $user->name]);
            endif;
        endif;

        return redirect()->route('user.show')
            ->withInput()
            ->with(['error' => true, 'user' => 'Erro ao atualizar o usuário']);
    }
}
