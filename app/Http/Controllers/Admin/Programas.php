<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Produtos;
use Illuminate\Http\Request;
use App\Models\Programa;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Programas extends Controller
{
    public $tipo_midia = 14;

    public function index()
    {
        $dados['programas']  = Programa::all();
        return view('admin/programas/programas', $dados);
    }


    public function create()
    {
        $dados['put']    = false;
         $dados['dados'] = '';
         $dados['route'] = 'admin/programas/store'; 
         return view('admin/programas/dados', $dados);
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

            $programas = new Programa();

            $programas->titulo  = $request->titulo;
            $programas->texto   = $request->texto;
            $programas->codigo  = $request->codigo;
            $programas->data    = $request->data;

            $programas->save();

            session()->flash('flash_message', 'Programa cadastrada com sucesso!');

            return redirect('admin/programas/listar');

        endif;
    }

    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['put']       = true;
        $dados['dados']     = Programa::findOrFail($id);
        $dados['route']     = 'admin/programas/atualizar/'.$id;

        return view('admin/programas/dados', $dados);
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

            return redirect('admin/programas/editar/'.$id);
        endif; 
    }


    public function destroy($id)
    {
        Midia::excluir($id);

        Programa::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/programas/listar');
    }

    public function updateStatus($status, $id)
    {
        $dado         = Programa::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return redirect('admin/programas/listar');
    }
}
