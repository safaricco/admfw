<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Patrocinador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Patrocinadores extends Controller
{
    public $tipo_midia = 17;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['patrocinadores'] = Patrocinador::all();
            return view('admin/patrocinadores/patrocinadores', $dados);

        } catch (\Exception $e) {

            LogR::exception('index patrocinadores', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function create()
    {
        try {
            $dados['put']      = false;
            $dados['dados']    = '';
            $dados['route']    = 'admin/patrocinadores/store';
            return view('admin/patrocinadores/dados', $dados);
        } catch (\Exception $e) {

            LogR::exception('create patrocinadores', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'endereco'  => 'required|string',
            'telefone'  => 'required|string',
            'link'      => 'required|string',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/patrocinadores/novo')->withErrors($validation)->withInput();
        else :

            try {
                $patrocinadores = new Patrocinador();

                $patrocinadores->titulo    = $request->titulo;
                $patrocinadores->texto     = $request->texto;
                $patrocinadores->endereco  = $request->endereco;
                $patrocinadores->telefone  = $request->telefone;
                $patrocinadores->link      = $request->link;

                $patrocinadores->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $patrocinadores->id_patrocinador);

                endif;

                session()->flash('flash_message', 'Patrocinador cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($patrocinadores, $e);
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
            $dados['dados']     = Patrocinador::findOrFail($id);
            $dados['route']     = 'admin/patrocinadores/atualizar/'.$id;

            return view('admin/patrocinadores/dados', $dados);
        } catch (\Exception $e) {

            LogR::exception('show patrocinadores', $e);
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
            'endereco'  => 'required|string',
            'telefone'  => 'required|string',
            'link'      => 'required|string',
            'imagem'    => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/patrocinadores/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $patrocinadores = Patrocinador::findOrFail($id);

                $patrocinadores->titulo    = $request->titulo;
                $patrocinadores->texto     = $request->texto;
                $patrocinadores->endereco  = $request->endereco;
                $patrocinadores->telefone  = $request->telefone;
                $patrocinadores->link      = $request->link;

                $patrocinadores->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $patrocinadores->id_patrocinador);

                endif;

                session()->flash('flash_message', 'Patrocinador alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($patrocinadores, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();
        endif; 
    }

    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Patrocinador::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy patrocinadores', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }
        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Patrocinador::findOrFail($id);

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
