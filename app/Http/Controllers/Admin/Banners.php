<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Banners extends Controller
{
    public $tipo_midia = 1;

    public function index()
    {
        $dados['banners']  = Banner::all();
        return view('admin/banners/banners', $dados);
    }


    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/banners/store'; 
        return view('admin/banners/dados', $dados);
    }

    public function store(Request $request)
    {
          $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'link'      => 'string',
            'data'      => 'date',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/banners/novo')->withErrors($validation)->withInput();
        else :

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
        $dados['dados']     = Banner::findOrFail($id);
        $dados['route']     = 'admin/banners/atualizar/'.$id;

        return view('admin/banners/dados', $dados);
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

            $banner = Banner::findOrFail($id);

            $banner->titulo         = $request->titulo;
            $banner->texto          = $request->texto;
            $banner->link           = $request->link;

            $banner->save();

            if ($request->hasFile('imagem')) :

                Midia::uploadUnico($this->tipo_midia, $banner->id_banner);

            endif;

            session()->flash('flash_message', 'Banners alterada com sucesso!');

            return Redirect::back();
        endif;
    }

    public function destroy($id)
    {
        Midia::excluir($id, $this->tipo_midia);

        Banner::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Banner::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}