<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destaque;
use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Destaques extends Controller
{

    private $tipo_midia = 22;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.destaques.destaques', ['destaques' => Destaque::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/destaques/store';

        return view('admin/destaques/dados', $dados);
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
            'nome'         => 'required|string',
            'data'         => 'required|date',
            'hora'         => 'required|string',
            'profissional' => 'required|string',
            'imagem'       => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/destaques/novo')->withErrors($validation)->withInput();
        else :

            $destaque = new Destaque();

            $destaque->nome         = $request->nome;
            $destaque->data         = date('Y-m-d', strtotime($request->data));
            $destaque->hora         = $request->hora;
            $destaque->profissional = $request->profissional;

            $destaque->save();

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO N�O EST� CORROMPIDO
            if ($request->hasFile('imagem')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARI�VEL $nomeTipo CONT�M O NOME DO TIPO DA MIDIA E SER� USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $destaque->id_destaques;
                $midia->descricao           = $nomeTipo . ' criado automaticamente';
                $midia->save();

                $img = $request->file('imagem');

                $nomeOriginal = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                $novoNome     = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTEN��O DO ARQUIVO

                $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                $imagem = new Multimidia();                                                         // GRAVANDO NA TABELA MULTIMIDIA

                // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                $imagem->id_midia   = $midia->id_midia;
                $imagem->imagem     = $novoNome;
                $imagem->ordem      = $request->ordem;
                $imagem->video      = $request->video;

                $imagem->save();
            endif;

            session()->flash('flash_message', 'Banners cadastrada com sucesso!');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
