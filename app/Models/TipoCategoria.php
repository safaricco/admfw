<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCategoria extends Model
{
    protected $table        = 'tipo_categorias';
    protected $fillable     = ['titulo'];
    protected $primaryKey   = 'id_tipo_categoria';

    public function categorias()
    {
        return $this->hasMany('App\Models\Categoria', 'id_tipo_categoria');
    }

    public function subcategorias()
    {
        return $this->hasManyThrough('App\Models\Categoria', 'App\Models\Subcategoria', 'id_tipo_categoria', 'id_categoria');
    }
}
