<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissaoPerfil extends Model
{
    protected $table        = 'permissao_perfil';
    protected $fillable     = ['id_funcao' ,'id_perfil', 'id_role'];
    protected $primaryKey   = 'id_permissao_perfil';
}
