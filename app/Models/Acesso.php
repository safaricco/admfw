<?php

namespace App\Models;

use App\Models\Funcao;
use App\Models\PerfilUser;
use App\Models\PermissaoPerfil;
use App\Models\PermissaoUser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Acesso extends Model
{
    public static function perfilAtivo($idUser)
    {
        $idPerfil = PerfilUser::where('id_user', $idUser)->first()->id_perfil;
        $perfi      = Perfil::findOrFail($idPerfil);

        if ($perfi->status == 1)
            return true;
        else
            return false;
    }

    public static function userAtivo($idUser)
    {
        $user = User::findOrFail($idUser);

        if ($user->status == 1)
            return true;
        else
            return false;
    }

    public static function getFuncao($like)
    {
        $fun = Funcao::where('acesso', $like)->where('status', 1)->get();
        $id = 0;
        foreach($fun as $fu) :
            $id = $fu->id_funcao;
        endforeach;

        return $id;
    }

    public static function permissaoPerfil($idUser, $funcaoPermissao)
    {
        $idFuncao           = Acesso::getFuncao($funcaoPermissao);
        $perfil             = PerfilUser::where('id_user', $idUser)->first();
        $permissaoPerfil    = collect(PermissaoPerfil::where('id_funcao', $idFuncao)->where('id_perfil', $perfil->id_perfil)->get())->first();

        if (empty($permissaoPerfil)) :

            return false;

        elseif($permissaoPerfil->id_role == 2) :

            return true;

        elseif($permissaoPerfil->id_role == 3) :

            return false;

        endif;
    }

    public static function permissaoUser($idUser, $funcaoPermissao)
    {
        $idFuncao       = Acesso::getFuncao($funcaoPermissao);
        $permissaoUser  = collect(PermissaoUser::where('id_funcao', $idFuncao)->where('id_user', $idUser)->get())->first();


        if (empty($permissaoUser->id_role)) :

            return false;

        elseif($permissaoUser->id_role == 1) :

            return 'perfil';

        elseif($permissaoUser->id_role == 2) :

            return 'user';

        elseif($permissaoUser->id_role == 3) :

            return false;

        endif;
    }

    public static function permissao($funcaoPermissao)
    {
        $idUser = Auth::user()->id;

        if ($idUser != 1) :

            $permUser = Acesso::permissaoUser($idUser, $funcaoPermissao);

            if ($permUser == 'perfil') :

                if (Acesso::permissaoPerfil($idUser, $funcaoPermissao))

                    return true;

                else

                    return false;

            elseif ($permUser == 'user') :

                return true;

            else :

                return false;

            endif;

        else :

            return true;

        endif;
    }
}
