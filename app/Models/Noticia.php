<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table        = 'noticias';
    protected $fillable     = ['titulo', 'texto', 'data', 'status'];
    protected $primaryKey   = 'id_noticia';

    public function subcategoria()
    {
        return $this->hasMany('App\Models\Subcategoria', 'id_subcategoria');
    }

    public function tipoCategoria()
    {
        return $this->belongsTo('App\Models\TipoCategoria', 'id_tipo_categoria');
    }
}
