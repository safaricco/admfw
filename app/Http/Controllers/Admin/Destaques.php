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
        try {
            return view('admin.destaques.destaques', ['destaques' => Destaque::all()]);

        } catch (\Exception $e) {

            LogR::exception('index destaques', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $dados['put']   = false;
            $dados['dados'] = '';
            $dados['route'] = 'admin/destaques/store';

            return view('admin/destaques/dados', $dados);
        } catch (\Exception $e) {

            LogR::exception('create destaques', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
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

            try {
                $destaque = new Destaque();

                $destaque->nome         = $request->nome;
                $destaque->data         = date('Y-m-d', strtotime($request->data));
                $destaque->hora         = $request->hora;
                $destaque->profissional = $request->profissional;

                $destaque->save();

                // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO N�O EST� CORROMPIDO
                if ($request->hasFile('imagem')) :

                    Midia::uploadUnico($this->tipo_midia, $destaque->id_destaque);
                endif;

                session()->flash('flash_message', 'Banners cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($destaque, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

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
