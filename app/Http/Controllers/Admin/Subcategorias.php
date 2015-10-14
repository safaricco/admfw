<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categoria;
use App\Models\LogR;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Subcategorias extends Controller
{
    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $dados['subcategorias'] = Subcategoria::all();
            return view('admin/subcategorias/subcategorias', $dados);

        } catch (\Exception $e) {

            LogR::exception('index subcategorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $dados['put']           = false;
            $dados['dados']         = '';
            $dados['route']         = 'admin/subcategorias/store';
            $dados['categorias']    = Categoria::all();
            return view('admin/subcategorias/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create subcategorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_categoria'  => 'required|integer',
            'titulo'        => 'required|string',
        ]);

        if ($validation->fails()) :
            return redirect('admin/subcategorias/novo')->withErrors($validation)->withInput();
        else :

            try {
                $sub = new Subcategoria();

                $sub->id_categoria  = $request->id_categoria;
                $sub->titulo        = $request->titulo;

                $sub->save();

                session()->flash('flash_message', 'Subcategoria cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($sub, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $dados['put']           = true;
            $dados['dados']         = Subcategoria::findOrFail($id);
            $dados['route']         = 'admin/subcategorias/update';
            $dados['categorias']    = Categoria::all();
            return view('admin/subcategorias/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('edit subcategorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'id_categoria'  => 'required|integer',
            'titulo'        => 'required|string',
        ]);

        if ($validation->fails()) :
            return redirect('admin/subcategorias/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $sub = Subcategoria::findOrFail($id);

                $sub->id_categoria  = $request->id_categoria;
                $sub->titulo        = $request->titulo;

                $sub->save();

                session()->flash('flash_message', 'Subcategoria alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($sub, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }
            return Redirect::back();

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Subcategoria::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');
        } catch (\Exception $e) {

            LogR::exception('destroy subcategorias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Subcategoria::findOrFail($id);

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
