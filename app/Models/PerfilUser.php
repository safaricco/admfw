<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilUser extends Model
{
    protected $table        = 'perfil_user';
    protected $fillable     = ['id_perfil' ,'id_user'];
    protected $primaryKey   = 'id_perfil_user';
}
