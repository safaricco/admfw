<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventosFoto;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Eventos extends Controller
{
    public $tipo_midia = 7;
    
    public function index()
    {
        $dados['eventos']  = Evento::all();
        return view('admin/eventos/eventos', $dados);
    }

    public function create()
    {
        $dados['put']   = false;
        $dados['dados'] = '';
        $dados['route'] = 'admin/eventos/store';
        return view('admin/eventos/dados', $dados);
    }


    public function store(Request $request)
    {
          $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            //'data'     => 'string',
            'imagem' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/eventos/novo')->withErrors($validation)->withInput();
        else :

            $evento = new Evento();

            $evento->titulo    = $request->titulo;
            $evento->texto     = $request->texto;
            $evento->data      = date('Y-m-d');

            $evento->save();

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $evento->id_evento);

            endif;

            session()->flash('flash_message', 'Evento cadastrada com sucesso!');

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
        $dados['dados']     = Evento::findOrFail($id);
        $dados['route']     = 'admin/eventos/atualizar/'.$id;

        return view('admin/eventos/dados', $dados);
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
            'imagem' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/eventos/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $evento = Evento::findOrFail($id);

            $evento->titulo    = $request->titulo;
            $evento->texto     = $request->texto;

            $evento->save();

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $evento->id_evento);

            endif;

            session()->flash('flash_message', 'Evento alterada com sucesso!');

            return Redirect::back();
        endif; 
    }

    public function destroy($id)
    {
        Midia::excluir($id, $this->tipo_midia);

        Evento::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Evento::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
