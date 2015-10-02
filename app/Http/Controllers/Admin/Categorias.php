<?php

namespace App\Http\Controllers\Admin;

use App\Models\TipoCategoria;
use Illuminate\Http\Request;
use App\Models\Categoria;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Categorias extends Controller
{
    public function index()
    {
        $dados['categorias']  = Categoria::all();
        return view('admin/categorias/categorias', $dados);
    }


    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['tipos'] = TipoCategoria::all();
        $dados['route'] = 'admin/categorias/store';
        return view('admin/categorias/dados', $dados);
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

            $categoria                      = new Categoria();

            $categoria->id_tipo_categoria   = $request->tipo_categoria;
            $categoria->titulo              = $request->titulo;

            $categoria->save();

            session()->flash('flash_message', 'Categoria cadastrada com sucesso!');

            return redirect('admin/categorias/listar');

        endif;
    }


    public function show($id)
    {
        $dados['put']   = false;
        $dados['tipos'] = TipoCategoria::all();
        $dados['dados'] = Categoria::findOrFail($id);
        $dados['route'] = 'admin/categorias/atualizar/'.$id;

        return view('admin/categorias/dados', $dados);
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

            $categoria = Categoria::findOrFail($id);

            $categoria->id_tipo_categoria   = $request->tipo_categoria;
            $categoria->titulo              = $request->titulo;

            $categoria->save();

            session()->flash('flash_message', 'Categoria alterada com sucesso!');

            return redirect('admin/categorias/listar');

        endif; 

    }


    public function destroy($id)
    {
        Categoria::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/categorias/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Categoria::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/categorias/listar');
    }
}
