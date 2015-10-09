<?php

namespace App\Http\Controllers\Admin;

use App\Models\Foto;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Fotos extends Controller
{
    public $tipo_midia = 8;

    public function index()
    {
        $dados['fotos']  = Foto::all();
        return view('admin/fotos/fotos', $dados);
    }

    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/fotos/store';
        return view('admin/fotos/dados', $dados);
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
            return redirect('admin/fotos/novo')->withErrors($validation)->withInput();
        else :

            $foto = new Foto();

            $foto->titulo    = $request->titulo;
            $foto->texto     = $request->texto;
            $foto->data      = date('Y-m-d');

            $foto->save();

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $foto->id_foto);

            endif;

            session()->flash('flash_message', 'Galerias cadastrada com sucesso!');

            return Redirect::back();

        endif;
    }


    public function show($id)
    {
        $dados['imagens']   = Midia::imagens($this->tipo_midia, $id);
        $dados['put']       = true;
        $dados['dados']     = Foto::findOrFail($id);
        $dados['route']     = 'admin/fotos/atualizar/'.$id;

        return view('admin/fotos/dados', $dados);
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
            return redirect('admin/fotos/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $foto           = Foto::findOrFail($id);

            $foto->titulo   = $request->titulo;
            $foto->texto    = $request->texto;

            $foto->save();

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $foto->id_foto);

            endif;

            session()->flash('flash_message', 'Galeria alterada com sucesso!');

            return Redirect::back();
        endif;
    }


    public function destroy($id)
    {
        Midia::excluir($id, $this->tipo_midia);

        Foto::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Foto::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
