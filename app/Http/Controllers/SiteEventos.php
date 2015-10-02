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
        $dados['dados'] = Evento::all();
        return view('eventos', $dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['dados']     = Evento::findOrFail($id);
        return view('evento', $dados);
    }
}
