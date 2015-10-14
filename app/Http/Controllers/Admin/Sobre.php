<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Sobres;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Sobre extends Controller
{
    public $tipo_midia = 16;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function show($id)
    {
        try {
            $dados['imagens']   = Midia::imagens($this->tipo_midia, $id);
            $dados['put']       = true;
            $dados['dados']     = Sobres::findOrFail($id);;
            $dados['route']     = 'admin/sobre/atualizar/'.$id;

            return view('admin/sobre/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show sobre', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
            'imagens[]' => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/sobre/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $sobre = Sobres::findOrFail($id);

                $sobre->titulo    = $request->titulo;
                $sobre->texto     = $request->texto;

                $sobre->save();

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $id);

                endif;

                session()->flash('flash_message', 'Sobre alterada com sucesso!');
            } catch (\Exception $e) {

                LogR::exception($sobre, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();
        endif; 
    }
}
