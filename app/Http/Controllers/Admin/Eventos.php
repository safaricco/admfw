<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventosFoto;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Eventos extends Controller
{
    public $tipo_midia = 7;
    
    public function index()
    {
        $dados['eventos']  = Evento::all();
        return view('admin/eventos/eventos', $dados);
    }

    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/eventos/store';
        return view('admin/eventos/dados', $dados);
    }


    public function store(Request $request)
    {
          $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            //'data'     => 'string',
            'imagem' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/eventos/novo')->withErrors($validation)->withInput();
        else :

            $evento = new Evento();

            $evento->titulo    = $request->titulo;
            $evento->texto     = $request->texto;
            $evento->data      = date('Y-m-d');

            $evento->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $evento->id_evento;
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

            session()->flash('flash_message', 'Evento cadastrada com sucesso!');

            return redirect('admin/eventos/listar');

        endif;
    }

    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['put']       = true;
        $dados['dados']     = Evento::findOrFail($id);
        $dados['route']     = 'admin/eventos/atualizar/'.$id;

        return view('admin/eventos/dados', $dados);
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
            'imagem' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/eventos/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $evento = Evento::findOrFail($id);

            $evento->titulo    = $request->titulo;
            $evento->texto     = $request->texto;

            $evento->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagem')) :

                $mid = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
                if (empty($mid)) :
                    $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $evento->id_evento;
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

            session()->flash('flash_message', 'Evento alterada com sucesso!');

            return redirect('admin/eventos/editar/'.$id);
        endif; 
    }

    public function destroy($id)
    {
        Midia::excluir($id);

        Evento::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/eventos/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Evento::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/eventos/listar');
    }
}
