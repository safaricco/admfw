<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Midia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteEventos extends Controller
{
    public $tipo_midia = 7;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['eventos']   = Evento::where('status', '=', 1)->get();
        $dados['imagens']   = Midia::where('id_tipo_midia', '=', $this->tipo_midia)->get();
        return view('site/eventos', $dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first())->first();

        if (!empty($idMidia)) :
            $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        else :
            $dados['imagens']   = '';
        endif;


        $dados['destacada']     = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
        $dados['evento']        = Evento::findOrFail($id);
        return view('site/eventos-page', $dados);
    }
}
