<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function upload(Request $request, $tipo, $registroTabela)
    {
        // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS
        $nomeTipo = TipoMidia::findOrFail($tipo)->descricao;

        // CRIANDO O REGISTRO PAI NA TABELA MIDIA
        $midia                      = new Midia();
        $midia->id_tipo_midia       = $tipo;
        $midia->id_registro_tabela  = $registroTabela;
        $midia->descricao           = $nomeTipo . ' criado automaticamente com o banner';
        $midia->save();

        // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA
        #foreach ($request-> as $img) :

            // VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO
                $nomeOriginal   = $request->file('imagem')->getClientOriginalName();

                // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO
                $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $request->file('imagem')->getClientOriginalExtension();

                // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"
                $request->file('imagem')->move('uploads/' . $nomeTipo, $novoNome);

                // GRAVANDO NA TABELA MULTIMIDIA
                $imagem                     = new Multimidia();

                // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                $imagem->id_midia   = $midia->id_midia;
                $imagem->imagem     = $novoNome or '';
                $imagem->descricao  = $request->descricao or '';
                $imagem->link       = $request->link or '';
                $imagem->ordem      = $request->ordem or '';
                $imagem->video      = $request->video or '';

                $imagem->save();

            endif;


        #endforeach;
    }

    public static function multiupload($tipo, $campo, $registroTabela, $atributos)
    {
        // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS
        $nomeTipo = TipoMidia::findOrFail($tipo)->descricao;

        // CRIANDO O REGISTRO PAI NA TABELA MIDIA
        $midia                      = new Midia();
        $midia->id_tipo_midia       = $tipo;
        $midia->id_registro_tabela  = $registroTabela;
        $midia->descricao           = $nomeTipo . ' criado automaticamente com o banner';
        $midia->save();

        // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA
        foreach ($campo as $img) :

            // VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($img->isValid()) :

                // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO
                $nomeOriginal   = $img->getClientOriginalName();

                // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO
                $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();

                // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"
                $img->move('uploads/' . $nomeTipo, $novoNome);

                // GRAVANDO NA TABELA MULTIMIDIA
                $imagem                     = new Multimidia();

                // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                $imagem->id_midia   = $midia->id_midia;
                $imagem->imagem     = $novoNome or '';
                $imagem->descricao  = $atributos->descricao or '';
                $imagem->link       = $atributos->link or '';
                $imagem->ordem      = $atributos->ordem or '';
                $imagem->video      = $atributos->video or '';

                $imagem->save();

            endif;
        endforeach;
    }
}
