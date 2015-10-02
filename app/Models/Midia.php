<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Midia extends Model
{
    protected $table        = 'midia';
    protected $fillable     = ['id_tipo_midia', 'id_registro_tabela' ,'descricao' ,'link' ,'imagem' ,'video' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_midia';

    // CRIANDO O RELACIONAMENTO REVERSO DA TABELA TIPOMIDIA COM A TABELA MIDIA
    public function tipo_midia()
    {
        return $this->belongsTo('App\Models\TipoMidia', 'id_tipo_midia');
    }

    // CRIANDO O RELACIONAMENTO DA TABELA MIDIA COM A TABELA MULTIMIDIA
    public function multimidia()
    {
        return $this->hasMany('App\Models\Multimidia', 'id_midia');
    }

    public static function excluir($idRegistro)
    {
        $hasMidia      = collect(Midia::where('id_registro_tabela', $idRegistro)->get());

        if($hasMidia->contains('id_registro_tabela', $idRegistro)) :

            $midia      = Midia::where('id_registro_tabela', $idRegistro)->first();

            $tipoMidia  = TipoMidia::findOrFail($midia->id_tipo_midia);

            $multimidia = Multimidia::where('id_midia', $midia->id_midia)->get();

            foreach($multimidia as $foto) :

                unlink('uploads/'. $tipoMidia->descricao . '/' . $foto->imagem);
                Multimidia::destroy($foto->id_multimidia);

            endforeach;

            Midia::destroy($midia->id_midia);

        endif;
    }
}
