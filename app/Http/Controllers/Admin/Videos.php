<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Video;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Videos extends Controller
{
    public $tipo_midia = 18;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['videos']  = Video::all();
            return view('admin/videos/videos', $dados);

        } catch (\Exception $e) {

            LogR::exception('index videos', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function create()
    {
        try {
            $dados['put']   = false;
            $dados['dados'] = '';
            $dados['route'] = 'admin/videos/store';
            return view('admin/videos/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create videos', $e);
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
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/videos/novo')->withErrors($validation)->withInput();
        else :

            try {
                $video = new Video();

                $video->titulo    = $request->titulo;
                $video->texto     = $request->texto;
                $video->data      = date('Y-m-d');

                $video->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $video->id_servico);

                endif;

                session()->flash('flash_message', 'Galerias cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($video, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }


    public function show($id)
    {
        try {
            $dados['imagens']   = Midia::imagens($this->tipo_midia, $id);
            $dados['destacada'] = Midia::destacada($this->tipo_midia, $id);
            $dados['put']       = true;
            $dados['dados']     = Video::findOrFail($id);
            $dados['route']     = 'admin/videos/atualizar/'.$id;

            return view('admin/videos/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show videos', $e);
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
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/videos/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $video           = Video::findOrFail($id);

                $video->titulo   = $request->titulo;
                $video->texto    = $request->texto;

                $video->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $video->id_servico);

                endif;

                session()->flash('flash_message', 'Galeria alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($video, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();
        endif;
    }


    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Video::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy videos', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Video::findOrFail($id);

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
