<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Produtos;
use Illuminate\Http\Request;
use App\Models\Programa;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Programas extends Controller
{
    public $tipo_midia = 14;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['programas']  = Programa::all();
            return view('admin/programas/programas', $dados);
        } catch (\Exception $e) {

            LogR::exception('index programas', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }


    public function create()
    {
        try {
            $dados['put']    = false;
            $dados['dados'] = '';
            $dados['route'] = 'admin/programas/store';
            return view('admin/programas/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create programas', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'string',
            'codigo'    => 'string',
            'data'      => 'date',
        ]);

        if ($validation->fails()) :
            return redirect('admin/programas/novo')->withErrors($validation)->withInput();
        else :

            try {
                $programas = new Programa();

                $programas->titulo  = $request->titulo;
                $programas->texto   = $request->texto;
                $programas->codigo  = $request->codigo;
                $programas->data    = $request->data;

                $programas->save();

                session()->flash('flash_message', 'Programa cadastrada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($programas, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }
            return Redirect::back();

        endif;
    }

    public function show($id)
    {
        try {
            $dados['imagens'] = Midia::imagens($this->tipo_midia, $id);
            $dados['put'] = true;
            $dados['dados'] = Programa::findOrFail($id);
            $dados['route'] = 'admin/programas/atualizar/' . $id;

            return view('admin/programas/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show programas', $e);
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
            'texto'     => 'string',
            'codigo'    => 'string',
            'data'      => 'date',
        ]);

        if ($validation->fails()) :
            return redirect('admin/programas/editar/'.$id)->withErrors($validation)->withInput();
        else :


            $programas = Programa::findOrFail($id);

            $programas->titulo  = $request->titulo;
            $programas->texto   = $request->texto;
            $programas->codigo  = $request->codigo;
            $programas->data    = $request->data;

            $programas->save();

            session()->flash('flash_message', 'Programa alterada com sucesso!');

            return Redirect::back();
        endif; 
    }


    public function destroy($id)
    {
        try {

            Midia::excluir($id, $this->tipo_midia);

            Programa::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy programas', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Programa::findOrFail($id);

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
