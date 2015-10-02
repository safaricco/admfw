<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\Servicos;
use App\Models\Subcategoria;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class Servico extends Controller
{
    public $tipo_midia      = 13;
    public $tipo_categoria  = 2;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/servicos/servicos', ['servicos' => Servicos::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados['put']           = false;
        $dados['dados']         = '';
        $dados['route']         = 'admin/servicos/store';
        $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
        return view('admin/servicos/dados', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nome'              => 'required|string|unique:produtos',
            'descricao'         => 'string',
            'ref'               => 'string|unique:produtos',
            'id_subcategoria'   => 'required|integer',
            'imagem'            => 'image|mimes:jpg,png,jpeg,gif',
            'imagens[]'         => 'image|mimes:jpg,png,jpeg,gif'
        ]);
        if ($validation->fails()) :
            return redirect('admin/servicos/novo')->withErrors($validation)->withInput();
        else :

            $servico = new Servicos();

            $servico->nome              = $request->nome;
            $servico->descricao         = $request->descricao;
            $servico->ref               = $request->ref;
            $servico->id_subcategoria   = $request->id_subcategoria;

            $servico->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $servico->id_servico;
                $midia->descricao           = $nomeTipo . ' criado automaticamente';
                $midia->save();

                // IMAGEM DESTACADA
                if ($request->hasFile('imagem')) :
                    $nomeOrigDest   = $request->file('imagem')->getClientOriginalName();                                                // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $nomeDestacada       = md5(uniqid($nomeOrigDest)) . '.' . $request->file('imagem')->getClientOriginalExtension();   // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $request->file('imagem')->move('uploads/' . $nomeTipo, $nomeDestacada);                                             // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imgDest = Midia::findOrFail($midia->id_midia);
                    $imgDest->imagem_destacada = $nomeDestacada;
                    $imgDest->save();
                endif;

                // CONTINUANDO COM OUTRAS IMAGENS
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

            session()->flash('flash_message', 'Produto cadastrado com sucesso!');

            return Redirect::back();

        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first())->first();

        if (!empty($idMidia)) :
            $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
            $dados['destacada'] = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
        else :
            $dados['imagens']   = '';
            $dados['destacada'] = '';
        endif;

        $dados['put']           = true;
        $dados['dados']         = Servicos::findOrFail($id);
        $dados['route']         = 'admin/servicos/atualizar/'.$id;
        $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
        return view('admin/servicos/dados', $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'nome'              => 'required|string',
            'descricao'         => 'string',
            'ref'               => 'string',
            'id_subcategoria'   => 'required|integer',
            'imagens[]'         => 'image|mimes:jpg,png,jpeg,gif',
            'imagem'            => 'image|mimes:jpg,png,jpeg,gif'
        ]);
        if ($validation->fails()) :
            return redirect('admin/servicos/novo')->withErrors($validation)->withInput();
        else :

            $servico = Servicos::findOrFail($id);

            $servico->nome              = $request->nome;
            $servico->descricao         = $request->descricao;
            $servico->ref               = $request->ref;
            $servico->id_subcategoria   = $request->id_subcategoria;

            $servico->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $mid = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
                if (empty($mid)) :
                    $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $servico->id_servico;
                    $midia->descricao           = $nomeTipo . ' criado automaticamente com o banner';
                    $midia->save();

                    // IMAGEM DESTACADA
                    if ($request->hasFile('imagem')) :
                        $nomeOrigDest   = $request->file('imagem')->getClientOriginalName();                                                // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                        $nomeDestacada  = md5(uniqid($nomeOrigDest)) . '.' . $request->file('imagem')->getClientOriginalExtension();   // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                        $request->file('imagem')->move('uploads/' . $nomeTipo, $nomeDestacada);                                             // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                        $imgDest                    = Midia::findOrFail($midia->id_midia);
                        $imgDest->imagem_destacada  = $nomeDestacada;
                        $imgDest->save();

                    endif;

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

                else :

                    $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $servico->id_servico;
                    $midia->descricao           = $nomeTipo . ' criado automaticamente com o banner';
                    $midia->save();


                    // IMAGEM DESTACADA
                    if ($request->hasFile('imagem')) :
                        $nomeOrigDest   = $request->file('imagem')->getClientOriginalName();                                                // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                        $nomeDestacada  = md5(uniqid($nomeOrigDest)) . '.' . $request->file('imagem')->getClientOriginalExtension();   // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                        $request->file('imagem')->move('uploads/' . $nomeTipo, $nomeDestacada);                                             // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                        $imgDest                    = Midia::findOrFail($midia->id_midia);
                        $imgDest->imagem_destacada  = $nomeDestacada;
                        $imgDest->save();

                    endif;

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

            endif;

            session()->flash('flash_message', 'Produto alterado com sucesso!');

            return Redirect::back();

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Midia::excluir($id);

        Servicos::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Servicos::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
