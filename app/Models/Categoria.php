<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $table        = 'categorias';
    protected $fillable     = ['titulo','data'];
    protected $primaryKey   = 'id_categoria';

    public function subcategorias()
    {
        return $this->hasMany('App\Models\Subcategoria', 'id_subcategoria');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\TipoCategoria', 'id_tipo_categoria');
    }

    public function produtos()
    {
        return $this->hasManyThrough('App\Models\Subcategorias', 'App\Models\Produtos', 'id_subcategoria', 'id_produto');
    }

    public function servicos()
    {
        return $this->hasManyThrough('App\Models\Subcategorias', 'App\Models\Servico', 'id_subcategoria', 'id_servico');
    }

    public function noticias()
    {
        return $this->hasManyThrough('App\Models\Subcategorias', 'App\Models\Noticia', 'id_subcategoria', 'id_noticia');
    }

    public function imoveis()
    {
        return $this->hasManyThrough('App\Models\Subcategorias', 'App\Models\Imovel', 'id_subcategoria', 'id_imovel');
    }
}
