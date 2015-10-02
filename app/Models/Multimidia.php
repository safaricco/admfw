<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multimidia extends Model
{
    protected $table        = 'multimidia';
    protected $fillable     = ['id_midia' ,'descricao' ,'video' ,'link' ,'imagem' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_multimidia';

    public function midia()
    {
        return $this->belongsTo('App\Models\Midia', 'id_midia');
    }

    public static function excluir($idMultimidia)
    {
        $multimidia = Multimidia::findOrFail($idMultimidia);

        $tipoMidia  = TipoMidia::findOrFail(Midia::find($multimidia->id_midia)->id_tipo_midia);

        Multimidia::excluirThumb($tipoMidia->descricao, $multimidia->imagem);

        unlink('uploads/'. $tipoMidia->descricao . '/' . $multimidia->imagem);

        Multimidia::destroy($idMultimidia);
    }

    public static function excluirThumb($tipo, $img)
    {
        $diretorio = public_path()."/uploads/" . $tipo . '/';

        $arquivos = new \DirectoryIterator($diretorio);

        $cont = 1;

        foreach ($arquivos as $arquivo) :

            if ($arquivo != '..' || $arquivo != '.') :

                if (!is_dir($arquivo)) :

                    $nomeImagem = $arquivo->getFilename();

                    $im = explode('_', $nomeImagem);

                    if (count($im) > 1) :
                        if ($im[1] == $img) :
                            unlink('uploads/'. $tipo . '/' . $nomeImagem);
                        endif;
                    endif;

                endif;
            endif;

            $cont = $cont +1;

        endforeach;
    }
}
