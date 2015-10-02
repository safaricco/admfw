<?php

namespace App\Http\Middleware;


use App\Models\Acesso;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) :

            return Redirect::to('admin/login');

        else :

            $idUser = Auth::user()->id;

            if($idUser != 1) :

                if (Acesso::perfilAtivo($idUser) and Acesso::userAtivo($idUser)) :

                    $req = explode('/', $request->getPathInfo());

                    if ($req[2] != 'dashboard'):

                        if ($req[2] == 'configuracoes') :
                            $like   = $req[3];
                        else :
                            $like   = $req[2];
                        endif;

                        $permissaoUser  = Acesso::permissaoUser($idUser, $like);

                        if (!$permissaoUser) :

                            return view('admin/static/sem-permissao', ['tipo' => 'Usuário']);

                        elseif($permissaoUser == 1) :

                            // verificando se existe permissão para o perfil do usuário
                            $permissaoPerfil = Acesso::permissaoPerfil($idUser, $like);

                            if (!$permissaoPerfil) :

                                return view('admin/static/sem-permissao', ['tipo' => 'Perfil']);

                            elseif($permissaoPerfil) :

                                return $next($request);

                            endif;

                        elseif($permissaoUser) :

                            return $next($request);

                        endif;

                    endif;

                else :

                    return Redirect::to('admin/login');

                endif;

            endif;

        endif;

        return $next($request);
    }
}
