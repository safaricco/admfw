<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Request;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\BinaryOp\Mul;


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

    protected static function getIdMidia($tipo_midia, $idRegistro)
    {
        return collect(Midia::where('id_registro_tabela', $idRegistro)->where('id_tipo_midia', $tipo_midia)->first())->first();
    }

    public static function imagens($tipo_midia, $idRegistro)
    {
        $idMidia = Midia::getIdMidia($tipo_midia, $idRegistro);

        if (!empty($idMidia))
            return Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        else
            return '';
    }

    public static function destacada($tipo_midia, $idRegistro)
    {
        $idMidia = Midia::getIdMidia($tipo_midia, $idRegistro);

        if (!empty($idMidia))
            return Midia::findOrFail($idMidia);
        else
            return '';
    }

    public static function uploadTextarea($texto, $tipo_midia)
    {
        $nomeTipo   = TipoMidia::findOrFail($tipo_midia)->descricao;

        // gravando imagem do corpo da noticia
        $dom = new \DOMDocument();
        $dom->loadHtml($texto, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        // foreach <img> in the submited message
        foreach($images as $img) :

            $src = $img->getAttribute('src');

            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)) :

                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];

                // Generating a random filename
                $filename = md5(uniqid());
                $filepath = "uploads/" . $nomeTipo . "/" . $filename.'.'.$mimetype;

                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    ->encode($mimetype, 100) 	// encode file to the specified mimetype
                    ->save(public_path($filepath));

                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);

            endif;

        endforeach;

        return $dom->saveHTML();
    }

    public static function excluir($idRegistro, $tipo_midia)
    {
        $hasMidia       = collect(Midia::where('id_registro_tabela', $idRegistro)->where('id_tipo_midia', $tipo_midia)->get());

        if($hasMidia->contains('id_registro_tabela', $idRegistro)) :

            $midia      = Midia::where('id_registro_tabela', $idRegistro)->where('id_tipo_midia', $tipo_midia)->first();

            $tipoMidia  = TipoMidia::findOrFail($midia->id_tipo_midia);

            $multimidia = Multimidia::where('id_midia', $midia->id_midia)->get();

            foreach($multimidia as $foto) :

                unlink('uploads/'. $tipoMidia->descricao . '/' . $foto->imagem);
                Multimidia::destroy($foto->id_multimidia);

            endforeach;

            Midia::destroy($midia->id_midia);

        endif;
    }

    public static function uploadDestacada($tipo_midia, $idRegistro, $dados = null)
    {
        if (!is_null($dados))
            $dados  = (object) $dados;

        $file       = Request::file('imagem');

        $nomeTipo   = TipoMidia::findOrFail($tipo_midia)->descricao;

        $nomeOrig   = $file->getClientOriginalName();

        $nomeDest   = md5(uniqid($nomeOrig)) . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/' . $nomeTipo, $nomeDest);

        $midia = Midia::where('id_registro_tabela', $idRegistro)->where('id_tipo_midia', $tipo_midia)->first();

        if (!empty($midia)) :

            $midia->imagem_destacada    = $nomeDest;

            if (!empty($dados))
                $midia->ordem           = $dados->midia_ordem;

            $midia->save();

        else :

            $midia                      = new Midia();
            $midia->id_tipo_midia       = $tipo_midia;
            $midia->id_registro_tabela  = $idRegistro;
            $midia->imagem_destacada    = $nomeDest;
            $midia->descricao           = $nomeTipo . ' criado automaticamente';

            if (!empty($dados))
                $midia->ordem           = $dados->midia_ordem;

            $midia->save();

        endif;
    }

    public static function uploadUnico($tipo_midia, $idRegistro, $dados = null)
    {
        if (!is_null($dados))
            $dados  = (object) $dados;

        $file       = Request::file('imagem');

        $nomeTipo   = TipoMidia::findOrFail($tipo_midia)->descricao;

        $nomeOrig   = $file->getClientOriginalName();

        $novoNome   = md5(uniqid($nomeOrig)) . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/' . $nomeTipo, $novoNome);

        $midia = Midia::where('id_registro_tabela', $idRegistro)->where('id_tipo_midia', $tipo_midia)->first();

        if (!empty($midia)) :

           $multi           = new Multimidia();

           $multi->id_midia = $midia->id_midia;
           $multi->imagem   = $novoNome;

           if (!empty($dados)) :
               $multi->ordem = $dados->multimicia_ordem;
               $multi->video = $dados->multimicia_video;
           endif;

           $multi->save();


        else :


                // gravando dados na tabela midia
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $tipo_midia;
                $midia->id_registro_tabela  = $idRegistro;
                $midia->descricao           = $nomeTipo . ' criado automaticamente';

                if (!empty($dados))
                    $midia->ordem           = $dados->midia_ordem;

                $midia->save();

//            });

//            try {

                // gravando dados na tabela multimidia
                $multi                      = new Multimidia();

                $multi->id_midia            = $midia->id_midia;
                $multi->imagem              = $novoNome;

                if (!empty($dados)) :
                    $multi->ordem           = $dados->multimicia_ordem;
                    $multi->video           = $dados->multimicia_video;
                endif;

                $multi->save();


//            } catch (\Exception $e) {

//                dd($e);

//            }

        endif;
    }

    public static function uploadMultiplo($tipo_midia, $idRegistro, $dados = null)
    {
        if (!is_null($dados))
            $dados  = (object) $dados;

        $file       = Request::file('imagens');

        $nomeTipo   = TipoMidia::findOrFail($tipo_midia)->descricao;

        $midia = Midia::where('id_registro_tabela', $idRegistro)->where('id_tipo_midia', $tipo_midia)->first();

        if (!empty($midia)) :

            foreach ($file as $img) :

                $nomeOriginal       = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                $novoNome           = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                $multi              = new Multimidia();                                                         // GRAVANDO NA TABELA MULTIMIDIA
                $multi->id_midia    = $midia->id_midia;
                $multi->imagem      = $novoNome;

                if (!empty($dados)) :
                    $multi->ordem   = $dados->multimicia_ordem;
                    $multi->video   = $dados->multimicia_video;
                endif;

                $multi->save();

            endforeach;

        else :

            // gravando dados na tabela midia
            $midia                      = new Midia();
            $midia->id_tipo_midia       = $tipo_midia;
            $midia->id_registro_tabela  = $idRegistro;
            $midia->descricao           = $nomeTipo . ' criado automaticamente';

            if (!empty($dados))
                $midia->ordem           = $dados->midia_ordem;

            $midia->save();

            foreach ($file as $img) :

                $nomeOriginal           = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                $novoNome               = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                $multi                  = new Multimidia();                                                         // GRAVANDO NA TABELA MULTIMIDIA
                $multi->id_midia        = $midia->id_midia;
                $multi->imagem          = $novoNome;

                if (!empty($dados)) :
                    $multi->ordem       = $dados->multimicia_ordem;
                    $multi->video       = $dados->multimicia_video;
                endif;

                $multi->save();

            endforeach;

        endif;
    }
}
