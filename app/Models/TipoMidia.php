<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMidia extends Model
{
    protected $table        = 'tipo_midia';
    protected $fillable     = ['descricao'];
    protected $primaryKey   = 'id_tipo_midia';

    public function midias()
    {
        return $this->hasMany('App\Models\Midia', 'id_midia');
    }

    public function multimidia()
    {
        return $this->hasManyThrough('App\Models\Midia', 'App\Models\Multimidia', 'id_tipo_midia', 'id_midia');
    }
}
