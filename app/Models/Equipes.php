<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Equipes extends Model
{
    protected $table        = 'equipe';
    protected $fillable     = ['nome' ,'descricao' ,'funcao', 'facebook', 'twitter', 'status'];
    protected $primaryKey   = 'id_equipe';

    public static function equipe()
    {
        return DB::table('equipe')
            ->join('midia', 'midia.id_registro_tabela', '=', 'equipe.id_equipe')
            ->select(
                'equipe.*',
                'midia.imagem_destacada'
            )
            ->where('midia.id_tipo_midia',23)
            ->where('equipe.status', 1)
            ->groupBy('equipe.id_equipe')
            ->get();
    }
}
