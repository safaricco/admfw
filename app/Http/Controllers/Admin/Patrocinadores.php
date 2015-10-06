<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Patrocinador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Patrocinadores extends Controller
{
    public $tipo_midia = 17;

    public function index()
    {
        $dados['patrocinadores']  = Patrocinador::all();
        return view('admin/patrocinadores/patrocinadores', $dados);
    }

    public function create()
    {
         $dados['put']      = false;
         $dados['dados']    = '';
         $dados['route']    = 'admin/patrocinadores/store';
         return view('admin/patrocinadores/dados', $dados);
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
        $dados['dados']     = Patrocinador::findOrFail($id);
        $dados['route']     = 'admin/patrocinadores/atualizar/'.$id;

        return view('admin/patrocinadores/dados', $dados);
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

            return Redirect::back();
        endif; 
    }

    public function destroy($id)
    {
        Midia::excluir($id, $this->tipo_midia);

        Patrocinador::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Patrocinador::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
