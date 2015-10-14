<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table        = 'fotos';
    protected $fillable     = ['titulo' ,'texto' ,'link' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_foto';

    public static function galerias()
    {
        return DB::table('fotos')
            ->join('midia', 'midia.id_registro_tabela', '=', 'fotos.id_foto')
            ->select(
                'fotos.*',
                'midia.imagem_destacada'
            )
            ->where('midia.id_tipo_midia',8)
            ->where('fotos.status', 1)
            ->groupBy('fotos.id_foto')
            ->get();
    }

    public static function galerias_fotos()
    {
        return DB::table('fotos')
            ->join('midia', 'midia.id_registro_tabela', '=', 'fotos.id_foto')
            ->join('multimidia', 'multimidia.id_midia', '=', 'midia.id_midia')
            ->select(
                'fotos.id_foto',
                'multimidia.id_midia',
                'multimidia.imagem'
            )
            ->where('midia.id_tipo_midia',8)
            ->where('fotos.status', 1)
            ->get();
    }
}
