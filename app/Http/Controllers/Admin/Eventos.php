<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventosFoto;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Eventos extends Controller
{
    public $tipo_midia = 7;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['eventos']  = Evento::all();
            return view('admin/eventos/eventos', $dados);

        } catch (\Exception $e) {

            LogR::exception('index eventos', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function create()
    {
        try {
            $dados['put']   = false;
            $dados['dados'] = '';
            $dados['route'] = 'admin/eventos/store';
            return view('admin/eventos/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create eventos', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
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

            try {

                $evento = new Evento();

                $evento->titulo    = $request->titulo;
                $evento->texto     = $request->texto;
                $evento->data      = date('Y-m-d');

                $evento->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $evento->id_evento);

                endif;

                session()->flash('flash_message', 'Evento cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($evento, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    public function show($id)
    {
        try {
            $dados['imagens']   = Midia::imagens($this->tipo_midia, $id);
            $dados['put']       = true;
            $dados['dados']     = Evento::findOrFail($id);
            $dados['route']     = 'admin/eventos/atualizar/'.$id;

            return view('admin/eventos/dados', $dados);
        } catch (\Exception $e) {

            LogR::exception('show eventos', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
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

            try {
                $evento = Evento::findOrFail($id);

                $evento->titulo    = $request->titulo;
                $evento->texto     = $request->texto;

                $evento->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $evento->id_evento);

                endif;

                session()->flash('flash_message', 'Evento alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($evento, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();
        endif; 
    }

    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Evento::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');
        } catch (\Exception $e) {

            LogR::exception('destroy eventos', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Evento::findOrFail($id);

            $dado->status = $status;

            $dado->save();

            session()->flash('flash_message', 'Status alterado com sucesso!');

        } catch (\Exception $e) {

            LogR::exception($dado, $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }
        return Redirect::back();
    }
}
