<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Videos extends Controller
{
    public $tipo_midia = 18;

    public function index()
    {
        $dados['videos']  = Video::all();
        return view('admin/videos/videos', $dados);
    }

    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/videos/store';
        return view('admin/videos/dados', $dados);
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

            $video = new Video();

            $video->titulo    = $request->titulo;
            $video->texto     = $request->texto;
            $video->data      = date('Y-m-d');

            $video->save();

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $video->id_servico);

            endif;

            session()->flash('flash_message', 'Galerias cadastrada com sucesso!');

            return Redirect::back();

        endif;
    }


    public function show($id)
    {
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia))->first();

        if (!empty($idMidia->id_midia))
            $dados['imagens']   = Midia::find($idMidia->id_midia)->multimidia()->where('id_midia', $idMidia->id_midia)->get();
        else
            $dados['imagens']   = '';
        $dados['put']       = true;
        $dados['dados']     = Video::findOrFail($id);
        $dados['route']     = 'admin/videos/atualizar/'.$id;

        return view('admin/videos/dados', $dados);
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

            $video           = Video::findOrFail($id);

            $video->titulo   = $request->titulo;
            $video->texto    = $request->texto;

            $video->save();

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $video->id_servico);

            endif;

            session()->flash('flash_message', 'Galeria alterada com sucesso!');

            return Redirect::back();
        endif;
    }


    public function destroy($id)
    {
        Midia::excluir($id, $this->tipo_midia);

        Video::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Video::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
