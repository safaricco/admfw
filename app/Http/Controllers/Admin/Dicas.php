<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Dica;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


class Dicas extends Controller
{
    public $tipo_midia = 5;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }


    public function index()
    {
        try {
            $dados['dicas']  = Dica::all();
            return view('admin/dicas/dicas', $dados);
        } catch (\Exception $e) {

            LogR::exception('index dicas', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function create()
    {
        try {
            $dados['put']   = false;
            $dados['dados'] = '';
            $dados['route'] = 'admin/dicas/store';
            return view('admin/dicas/dados', $dados);
        } catch (\Exception $e) {

            LogR::exception('create dicas', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/dicas/novo')->withErrors($validation)->withInput();
        else :

            try {

                $dica = new Dica();

                $dica->titulo    = $request->titulo;
                $dica->texto     = $request->texto;

                $dica->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $dica->id_dica);

                endif;

                session()->flash('flash_message', 'Dica cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($dica, $e);
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
            $dados['dados']     = Dica::findOrFail($id);
            $dados['route']     = 'admin/dicas/atualizar/'.$id;

            return view('admin/dicas/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show dicas', $e);
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
            return redirect('admin/dicas/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $dica = Dica::findOrFail($id);

                $dica->titulo    = $request->titulo;
                $dica->texto     = $request->texto;

                $dica->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $dica->id_dica);

                endif;

                session()->flash('flash_message', 'Dicas alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($dica, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();
        endif; 
    }

    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Dica::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy dicas', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Dica::findOrFail($id);

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
