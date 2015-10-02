<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table        = 'perfil';
    protected $fillable     = ['descricao' ,'status'];
    protected $primaryKey   = 'id_perfil';

    public function users()
    {
        return $this->hasManyThrough('App\Models\PerfilUser', 'App\User', 'id_user', 'id');
    }
}
