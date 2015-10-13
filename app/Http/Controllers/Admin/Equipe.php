<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipes;
use App\Models\Midia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Equipe extends Controller
{
    private $tipo_midia = 23;

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
        return view('admin/equipe/equipe', ['equipe' => Equipes::all()]);
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
        $dados['route'] = 'admin/equipe/store';
        return view('admin/equipe/dados', $dados);
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
            'nome'      => 'required|string',
            'descricao' => 'required|string',
            'funcao'    => 'required|string',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/equipe/novo')->withErrors($validation)->withInput();
        else :

            $equipe             = new Equipes();

            $equipe->nome       = $request->nome;
            $equipe->descricao  = $request->descricao;
            $equipe->funcao     = $request->funcao;

            $equipe->save();

            if ($request->hasFile('imagem')) :

                Midia::uploadDestacada($this->tipo_midia, $equipe->id_equipe);

            endif;

            session()->flash('flash_message', 'Membro da equipe cadastrado com sucesso!');

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
        $dados['destacada'] = Midia::destacada($this->tipo_midia, $id);
        $dados['put']       = true;
        $dados['dados']     = Equipes::findOrFail($id);
        $dados['route']     = 'admin/equipe/atualizar/'.$id;
        return view('admin/equipe/dados', $dados);
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
            'nome'      => 'required|string',
            'descricao' => 'required|string',
            'funcao'    => 'required|string',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/equipe/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $equipe             = Equipes::findOrFail($id);

            $equipe->nome       = $request->nome;
            $equipe->descricao  = $request->descricao;
            $equipe->funcao     = $request->funcao;

            $equipe->save();

            if ($request->hasFile('imagem')) :

                Midia::uploadDestacada($this->tipo_midia, $equipe->id_equipe);

            endif;

            session()->flash('flash_message', 'Membro da equipe alterado com sucesso!');

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

        Equipes::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Equipes::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}