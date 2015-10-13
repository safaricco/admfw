<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\TipoCategoria;
use Illuminate\Http\Request;
use App\Models\Categoria;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Categorias extends Controller
{
    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['categorias']  = Categoria::all();
            return view('admin/categorias/categorias', $dados);

        } catch (\Exception $e) {

            LogR::exception('index categorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());
            return Redirect::back();
        }
    }


    public function create()
    {
        try {
            $dados['put']   = false;
            $dados['dados'] = '';
            $dados['tipos'] = TipoCategoria::all();
            $dados['route'] = 'admin/categorias/store';
            return view('admin/categorias/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create categorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tipo_categoria'    => 'required|integer',
            'titulo'            => 'required|string',
        ]);

        if ($validation->fails()) :
            return redirect('admin/categorias/novo')->withErrors($validation)->withInput();
        else :

            try {
                $categoria                      = new Categoria();

                $categoria->id_tipo_categoria   = $request->tipo_categoria;
                $categoria->titulo              = $request->titulo;

                $categoria->save();

                session()->flash('flash_message', 'Categoria cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($categoria, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }


    public function show($id)
    {
        try{
            $dados['put']   = false;
            $dados['tipos'] = TipoCategoria::all();
            $dados['dados'] = Categoria::findOrFail($id);
            $dados['route'] = 'admin/categorias/atualizar/'.$id;

            return view('admin/categorias/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show categorias', $e);
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
            'tipo_categoria'    => 'required|integer',
            'titulo'            => 'required|string',
        ]);

        if ($validation->fails()) :
            return redirect('admin/categorias/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try{
                $categoria = Categoria::findOrFail($id);

                $categoria->id_tipo_categoria   = $request->tipo_categoria;
                $categoria->titulo              = $request->titulo;

                $categoria->save();

                session()->flash('flash_message', 'Categoria alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($categoria, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif; 

    }


    public function destroy($id)
    {
        try{
            Categoria::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy categorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Categoria::findOrFail($id);

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
