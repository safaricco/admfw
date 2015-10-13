<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\Servicos;
use App\Models\Subcategoria;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


class Servico extends Controller
{
    public $tipo_midia      = 13;
    public $tipo_categoria  = 2;

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

            if ($request->hasFile('imagem')) :

                Midia::uploadDestacada($this->tipo_midia, $servico->id_servico);

            endif;

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $servico->id_servico);

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
        $dados['imagens']       = Midia::imagens($this->tipo_midia, $id);
        $dados['destacada']     = Midia::destacada($this->tipo_midia, $id);
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

            if ($request->hasFile('imagem')) :

                Midia::uploadDestacada($this->tipo_midia, $servico->id_servico);

            endif;

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $servico->id_servico);

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
        Midia::excluir($id, $this->tipo_midia);

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
