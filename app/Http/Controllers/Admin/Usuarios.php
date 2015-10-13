<?php

namespace App\Http\Controllers\Admin;

use App\Models\Funcao;
use App\Models\LogR;
use App\Models\Perfil;
use App\Models\PerfilUser;
use App\Models\PermissaoUser;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Usuarios extends Controller
{
    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $dados['usuarios']      = User::selecionarUsuarios();
            return view('admin/usuarios/usuarios', $dados);

        } catch (\Exception $e) {

            LogR::exception('index usuarios', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $dados['funcoes']       = Funcao::all();
            $dados['roles']         = Role::all();
            $dados['put']           = false;
            $dados['route']         = '/admin/configuracoes/usuarios/store';
            $dados['permissao']     = '';
            $dados['dados']         = '';
            $dados['perfis']        = Perfil::all();
            $dados['perfilUser']    = '';
            return view('admin/usuarios/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create usuarios', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'password'  => 'required|string',
            'id_perfil' => 'required|integer'
        ]);

        if ($validator->fails()) :
            return redirect('admin/configuracoes/usuarios/novo')->withErrors($validator)->withInput();
        else :

            try {
                $user           = new User();

                $user->name     = $request->name;
                $user->email    = $request->email;
                $user->password = bcrypt($request->password);

                $user->save();

                $funcoes = Funcao::all();

                $cont = 1;

                foreach ($funcoes as $funcao) :

                    try {
                        $permissao = new PermissaoUser();

                        $permissao->id_funcao   = $funcao->id_funcao;
                        $permissao->id_user     = $user->id;
                        $permissao->id_role     = $request->$cont;
                        $permissao->save();

                        $cont++;

                    } catch (\Exception $e) {

                        LogR::exception($permissao, $e);
                        session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

                    }
                endforeach;

                try {
                    $perfilUser             = new PerfilUser();
                    $perfilUser->id_perfil  = $request->id_perfil;
                    $perfilUser->id_user    = $user->id;
                    $perfilUser->save();

                } catch (\Exception $e) {

                    LogR::exception($perfilUser, $e);
                    session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

                }

                session()->flash('flash_message', 'Registro gravado com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($user, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $dados['put']           = true;
            $dados['route']         = '/admin/configuracoes/usuarios/atualizar/'.$id;
            $dados['dados']         = User::findOrFail($id);
            $dados['funcoes']       = Funcao::all();
            $dados['roles']         = Role::all();
            $dados['permissao']     = PermissaoUser::where('id_user', $id)->get();
            $dados['perfis']        = Perfil::all();
            $dados['perfilUser']    = PerfilUser::where('id_user', $id)->first();
            return view('admin/usuarios/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show usuarios', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $dados['user']  = User::findOrFail(Auth::user()->id);
            return view('admin/usuarios/perfil', $dados);

        } catch (\Exception $e) {

            LogR::exception('edit usuario', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validacao = Validator::make($request->all(), [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'password'  => 'string',
            'id_perfil' => 'required|integer'
        ]);

        if ($validacao->fails()) :
            return redirect('admin/configuracoes/usuarios/editar/'.$id)->withErrors($validacao)->withInput();
        else :

            try {
                $user           = User::find($id);

                $user->name     = $request->name;
                $user->email    = $request->email;

                if (!empty($request->password))
                    $user->password = bcrypt($request->password);

                $user->save();

                // gravando as permissões específicas do usuário
                $funcoes = Funcao::all();

                $cont = 1;

                foreach ($funcoes as $funcao) :

                    try {
                        $permissao = PermissaoUser::where('id_funcao', $funcao->id_funcao)->where('id_user', $user->id)->first();

                        $permissao->id_role = $request->$cont;
                        $permissao->save();

                        $cont++;

                    } catch (\Exception $e) {

                        LogR::exception($permissao, $e);
                        session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

                    }

                endforeach;

                try {
                    // gravando o vinculo do usuário com o perfil selecionado
                    $perfilUser             = PerfilUser::where('id_user', $id)->first();
                    $perfilUser->id_perfil  = $request->id_perfil;
                    $perfilUser->save();

                } catch (\Exception $e) {

                    LogR::exception($perfilUser, $e);
                    session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

                }

                session()->flash('flash_message', 'Registro atualizado com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($user, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updatePerfil(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
        ]);

        if ($validator->fails()) :
            return redirect('admin/perfil/'.$id)->withErrors($validator)->withInput();
        else :

            try {
                $user           = User::findOrFail($id);

                $user->name     = $request->name;

                $user->save();

                session()->flash('flash_message', 'Dados alterados com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($user, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateFoto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'imagem' => 'image|mimes:jpeg,bmp,png,jpg',
        ]);

        if ($validator->fails()) :
            return redirect('admin/perfil/'.$id)->withErrors($validator)->withInput();
        else :

            try {
                $user = User::findOrFail($id);

                if ($request->hasFile('imagem')) :

                    if ($request->file('imagem')->isValid()) :

                        $nomeOriginal   = $request->file('imagem')->getClientOriginalName();
                        $novoNome       = md5(uniqid($nomeOriginal)).'.'.$request->file('imagem')->getClientOriginalExtension();
                        $request->file('imagem')->move('webroot/images/perfisAdm/', $novoNome);

                        $user->imagem = $novoNome;

                        $user->save();
                    endif;
                endif;

                session()->flash('flash_message', 'Dados alterados com sucesso! Enviamos uma confirmação para o seu e-mail, verifique seu e-mail');


            } catch (\Exception $e) {

                LogR::exception($user, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }
            return Redirect::back();

        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateSenha(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password'              => 'confirmed:password_confirmation',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) :
            return redirect('admin/configuracoes/usuarios/perfil/editar/'.$id)->withErrors($validator)->withInput();
        else :

            try {
                $user           = User::findOrFail($id);

                $user->password = bcrypt($request->password);

                $user->save();

                session()->flash('flash_message', 'Senha alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($user, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    public function updateStatus($status, $id)
    {

        try {
            $user         = User::findOrFail($id);

            $user->status = $status;

            $user->save();

            session()->flash('flash_message', 'Status alterado com sucesso!');

        } catch (\Exception $e) {

            LogR::exception($user, $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }
}
