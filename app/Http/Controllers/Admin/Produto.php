<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\Produtos;
use App\Models\Subcategoria;
use App\Models\TipoMidia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class Produto extends Controller
{
    public $tipo_midia = 12;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin/produtos/produtos', ['produtos' => Produtos::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dados['put']           = false;
        $dados['dados']         = '';
        $dados['route']         = 'admin/produtos/store';
        $dados['subcategorias'] = Subcategoria::all();
        return view('admin/produtos/dados', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nome'              => 'required|string|unique:produtos',
            'descricao'         => 'string',
            'ref'               => 'string|unique:produtos',
            'idSubcategoria'    => 'required|integer',
//            'imagens'           => 'image|mimes:jpg,png,jpeg,gif'
        ]);
        if ($validation->fails()) :
            return redirect('admin/produtos/novo')->withErrors($validation)->withInput();
        else :

            $produto = new Produtos();

            $produto->nome              = $request->nome;
            $produto->descricao         = $request->descricao;
            $produto->ref               = $request->ref;
            $produto->idSubcategoria    = $request->idSubcategoria;

            $produto->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $produto->id_produto;
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

            session()->flash('flash_message', 'Produto cadastrado com sucesso!');

            return redirect('admin/produtos/listar');

        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $idMidia                = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']       = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['put']           = true;
        $dados['dados']         = Produtos::findOrFail($id);
        $dados['route']         = 'admin/produtos/atualizar/'.$id;
        $dados['subcategorias'] = Subcategoria::all();
        return view('admin/produtos/dados', $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'nome'              => 'required|string',
            'descricao'         => 'string',
            'ref'               => 'string',
            'idSubcategoria'    => 'required|integer',
            'imagens[]'         => 'image|mimes:jpg,png,jpeg,gif'
        ]);
        if ($validation->fails()) :
            return redirect('admin/produtos/novo')->withErrors($validation)->withInput();
        else :

            $produto = Produtos::findOrFail($id);

            $produto->nome              = $request->nome;
            $produto->descricao         = $request->descricao;
            $produto->ref               = $request->ref;
            $produto->idSubcategoria    = $request->idSubcategoria;

            $produto->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagem')) :

                $mid = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
                if (empty($mid)) :
                    $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $produto->id_produto;
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

            session()->flash('flash_message', 'Produto alterado com sucesso!');

            return redirect('admin/produtos/listar');

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Midia::excluir($id);

        Produtos::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/produtos/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Produtos::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/produtos/listar');
    }
}
