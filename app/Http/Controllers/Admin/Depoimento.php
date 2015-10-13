<?php

namespace App\Http\Controllers\Admin;

use App\Models\Depoimentos;
use App\Models\LogR;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Depoimento extends Controller
{
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
        return view('admin/depoimentos/depoimentos', ['depoimentos' => Depoimentos::all()]);

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
        $dados['route'] = 'admin/depoimentos/store';
        return view('admin/depoimentos/dados', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'nome'  => 'required|string',
            'texto' => 'string',
            'video' => 'string'
        ]);

        if($validation->fails()) :
            redirect('admin/depoimentos/novo')->withErrors($validation)->withInput();
        else :

            $depoimento         = new Depoimentos();

            $depoimento->nome   = $request->nome;
            $depoimento->texto  = $request->texto;
            $depoimento->video  = $request->video;

            $depoimento->save();

            session()->flash('flash_message', 'Registro gravado com sucesso!');

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
        $dados['put']   = true;
        $dados['dados'] = Depoimentos::findOrFail($id);
        $dados['route'] = 'admin/depoimentos/atualizar/'.$id;
        return view('admin/depoimentos/dados', $dados);
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
        $validation = Validator::make($request->all(),[
            'nome'  => 'required|string',
            'texto' => 'string',
            'video' => 'string'
        ]);

        if($validation->fails()) :
            redirect('admin/depoimentos/editar/' . $id)->withErrors($validation)->withInput();
        else :

            $depoimento         = Depoimentos::findOrFail($id);

            $depoimento->nome   = $request->nome;
            $depoimento->texto  = $request->texto;
            $depoimento->video  = $request->video;

            $depoimento->save();

            session()->flash('flash_message', 'Registro atualizado com sucesso!');

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
        Depoimentos::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Depoimentos::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
