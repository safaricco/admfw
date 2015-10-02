<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Banners extends Controller
{
    public $tipo_midia = 1;

    public function index()
    {
        $dados['banners']  = Banner::all();
        return view('admin/banners/banners', $dados);
    }


    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/banners/store'; 
        return view('admin/banners/dados', $dados);
    }

    public function store(Request $request)
    {
          $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'link'      => 'string',
            'data'      => 'date',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/banners/novo')->withErrors($validation)->withInput();
        else :

            $banner = new Banner();

            $banner->titulo         = $request->titulo;
            $banner->texto          = $request->texto;
            $banner->link           = $request->link;
            $banner->data_inicio    = date('Y-m-d');

            $banner->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $banner->id_banner;
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

            session()->flash('flash_message', 'Banners cadastrada com sucesso!');

            return redirect('admin/banners/listar');

        endif;
    }


    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();

        $dados['put']       = true;
        $dados['dados']     = Banner::findOrFail($id);
        $dados['route']     = 'admin/banners/atualizar/'.$id;

        return view('admin/banners/dados', $dados);
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
            'link'      => 'string',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/banners/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $banner = Banner::findOrFail($id);

            $banner->titulo         = $request->titulo;
            $banner->texto          = $request->texto;
            $banner->link           = $request->link;

            $banner->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagem')) :

                $mid = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
                if (empty($mid)) :
                    $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $banner->id_banner;
                    $midia->descricao           = $nomeTipo . ' criado automaticamente com o banner';
                    $midia->save();

                else :

                    $nomeTipo       = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                    $midia          = Midia::where('id_registro_tabela', $id)->first();

                    $nomeOriginal   = $request->file('imagem')->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $request->file('imagem')->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $request->file('imagem')->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = Multimidia::where('id_midia', $midia->id_midia)->first();

                    if (empty($imagem))
                        $imagem = new Multimidia();

                    // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();
                endif;

            endif;

            session()->flash('flash_message', 'Banners alterada com sucesso!');

            return redirect('admin/banners/editar/'.$id);
        endif;
    }

    public function destroy($id)
    {
        Midia::excluir($id);

        Banner::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/banners/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Banner::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/banners/listar');
    }
}