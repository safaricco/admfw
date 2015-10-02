<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermissaoUser extends Model
{
    protected $table        = 'permissao_user';
    protected $fillable     = ['id_funcao' ,'id_user', 'id_role'];
    protected $primaryKey   = 'id_permissao_user';

    public function selecionarPermissao($idFuncao, $idUser)
    {
        return DB::table('permissao_user')
            ->where('id_funcao', '=',$idFuncao)
            ->where('id_user', '=',$idUser)
            ->get();
    }
}
