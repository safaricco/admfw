<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Sobres;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Sobre extends Controller
{
    public $tipo_midia = 16;

    public function show($id)
    {
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia))->first();

        if (!empty($idMidia->id_midia))
            $dados['imagens']   = Midia::find($idMidia->id_midia)->multimidia()->where('id_midia', $idMidia->id_midia)->get();
        else
            $dados['imagens']   = '';
        $dados['put']       = true;
        $dados['dados']     = Sobres::findOrFail($id);;
        $dados['route']     = 'admin/sobre/atualizar/'.$id;

        return view('admin/sobre/dados', $dados);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'imagem' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/sobre/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $sobre = Sobres::findOrFail($id);

            $sobre->titulo    = $request->titulo;
            $sobre->texto     = $request->texto;

            $sobre->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo   = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                $midia      = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();

                if (count($midia) < 1) :

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $sobre->id_sobre;
                    $midia->descricao           = $nomeTipo . ' criado automaticamente';
                    $midia->save();

                endif;

                foreach ($request->file('imagens') as $img) :

                    $nomeOriginal   = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = Multimidia::where('id_midia', $midia->id_midia);

                    if (isset($imagem))
                        $imagem = new Multimidia();

                    // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();

                endforeach;

            endif;

            session()->flash('flash_message', 'Sobre alterada com sucesso!');

            return Redirect::back();
        endif; 
    }
}
