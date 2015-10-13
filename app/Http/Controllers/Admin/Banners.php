<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class Banners extends Controller
{
    public $tipo_midia = 1;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['banners']  = Banner::all();
            return view('admin/banners/banners', $dados);

        } catch (\Exception $e) {

            LogR::exception('index banner', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());
            return Redirect::back();

        }
    }

    public function create()
    {
        try {
            $dados['put']   = false;
            $dados['dados'] = '';
            $dados['route'] = 'admin/banners/store';
            return view('admin/banners/dados', $dados);


        } catch (\Exception $e) {

            LogR::exception('create banner', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());
            return Redirect::back();

        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'link'      => 'string',
            'data'      => 'date',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/banners/novo')->withErrors($validation)->withInput();
        else :

            try {

                $banner = new Banner();

                $banner->titulo         = $request->titulo;
                $banner->texto          = $request->texto;
                $banner->link           = $request->link;
                $banner->data_inicio    = date('Y-m-d');

                $banner->save();

                if ($request->hasFile('imagem')) :

                    Midia::uploadUnico($this->tipo_midia, $banner->id_banner);

                endif;

                session()->flash('flash_message', 'Banners cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($banner, $e);
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
            $dados['dados']     = Banner::findOrFail($id);
            $dados['route']     = 'admin/banners/atualizar/'.$id;

            return view('admin/banners/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show banner', $e);
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
            'link'      => 'string',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/banners/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $banner = Banner::findOrFail($id);

                $banner->titulo         = $request->titulo;
                $banner->texto          = $request->texto;
                $banner->link           = $request->link;

                $banner->save();

                if ($request->hasFile('imagem')) :

                    Midia::uploadUnico($this->tipo_midia, $banner->id_banner);

                endif;

                session()->flash('flash_message', 'Banners alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($banner, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();
        endif;
    }

    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Banner::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy banner', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Banner::findOrFail($id);

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