<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Patrocinador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Patrocinadores extends Controller
{
    public $tipo_midia = 17;

    public function index()
    {
        $dados['patrocinadores']  = Patrocinador::all();
        return view('admin/patrocinadores/patrocinadores', $dados);
    }

    public function create()
    {
         $dados['put']      = false;
         $dados['dados']    = '';
         $dados['route']    = 'admin/patrocinadores/store';
         return view('admin/patrocinadores/dados', $dados);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'endereco'  => 'required|string',
            'telefone'  => 'required|string',
            'link'      => 'required|string',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/patrocinadores/novo')->withErrors($validation)->withInput();
        else :

            $patrocinadores = new Patrocinador();

            $patrocinadores->titulo    = $request->titulo;
            $patrocinadores->texto     = $request->texto;
            $patrocinadores->endereco  = $request->endereco;
            $patrocinadores->telefone  = $request->telefone;
            $patrocinadores->link      = $request->link;

            $patrocinadores->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $patrocinadores->id_patrocinador;
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

            session()->flash('flash_message', 'Patrocinador cadastrada com sucesso!');

            return redirect('admin/patrocinadores/listar');

        endif;
    }

    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['put']       = true;
        $dados['dados']     = Patrocinador::findOrFail($id);
        $dados['route']     = 'admin/patrocinadores/atualizar/'.$id;

        return view('admin/patrocinadores/dados', $dados);
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
            'endereco'  => 'required|string',
            'telefone'  => 'required|string',
            'link'      => 'required|string',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/patrocinadores/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $patrocinadores = Patrocinador::findOrFail($id);

            $patrocinadores->titulo    = $request->titulo;
            $patrocinadores->texto     = $request->texto;
            $patrocinadores->endereco  = $request->endereco;
            $patrocinadores->telefone  = $request->telefone;
            $patrocinadores->link      = $request->link;

            $patrocinadores->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo   = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                $midia      = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();

                if (count($midia) < 1) :

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $patrocinadores->id_patrocinador;
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

            session()->flash('flash_message', 'Patrocinador alterada com sucesso!');

            return redirect('admin/patrocinadores/editar/'.$id);
        endif; 
    }

    public function destroy($id)
    {
        Midia::excluir($id);

        Patrocinador::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/patrocinadores/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Patrocinador::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/patrocinadores/listar');
    }
}
