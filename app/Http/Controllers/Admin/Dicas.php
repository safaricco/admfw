<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Dica;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class Dicas extends Controller
{
    public $tipo_midia = 5;

    public function index()
    {
        $dados['dicas']  = Dica::all();
        return view('admin/dicas/dicas', $dados);
    }

    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/dicas/store'; 
        return view('admin/dicas/dados', $dados);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/dicas/novo')->withErrors($validation)->withInput();
        else :

            $dica = new Dica();

            $dica->titulo    = $request->titulo;
            $dica->texto     = $request->texto;

            $dica->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $dica->id_dica;
                $midia->descricao           = $nomeTipo . ' criado automaticamente';
                $midia->save();

                foreach ($request->file('imagens') as $img) :

                    $nomeOriginal   = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = new Multimidia();                                                         // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();

                endforeach;

            endif;

            session()->flash('flash_message', 'Dica cadastrada com sucesso!');

            return Redirect::back();

        endif;
    }

    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();

        $dados['put']       = true;
        $dados['dados']     = Dica::findOrFail($id);
        $dados['route']     = 'admin/dicas/atualizar/'.$id;

        return view('admin/dicas/dados', $dados);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/dicas/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $dica = Dica::findOrFail($id);

            $dica->titulo    = $request->titulo;
            $dica->texto     = $request->texto;

            $dica->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo   = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                $midia      = Midia::where('id_registro_tabela', $id)->first();

                $imgFile = $request->file('imagens');

                foreach ($imgFile as $img) :

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

            session()->flash('flash_message', 'Dicas alterada com sucesso!');

            return Redirect::back();
        endif; 
    }

    public function destroy($id)
    {
        Midia::excluir($id);

        Dica::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Dica::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
