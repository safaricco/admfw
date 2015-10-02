<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcategoria extends Model
{
    protected $table        = 'subcategorias';
    protected $fillable     = ['id_categoria', 'titulo' ,'status'];
    protected $primaryKey   = 'id_subcategoria';

    public function produtos()
    {
        return $this->hasMany('App\Models\Produtos', 'id_subcategoria');
    }

    public function servicos()
    {
        return $this->hasMany('App\Models\Servicos', 'id_subcategoria');
    }

    public function noticias()
    {
        return $this->belongsTo('App\Models\Noticias', 'id_subcategoria');
    }

    public function imoveis()
    {
        return $this->hasMany('App\Models\Imovel', 'id_subcategoria');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categorias', 'id_subcategoria');
    }

    public static function subs($tipo)
    {
        return DB::table('subcategorias')
            ->join('categorias', 'categorias.id_categoria', '=', 'subcategorias.id_categoria')
            ->join('tipo_categorias', 'categorias.id_tipo_categoria', '=', 'tipo_categorias.id_tipo_categoria')
            ->select(
                'subcategorias.id_subcategoria',
                'subcategorias.titulo'
            )
            ->where('tipo_categorias.id_tipo_categoria', '=', $tipo)
            ->get();
    }
}
