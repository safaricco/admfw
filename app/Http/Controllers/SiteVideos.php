<?php

namespace App\Http\Controllers;

use App\Models\Midia;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteVideos extends Controller
{
    public $tipo_midia = 18;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['dados'] = Video::all();
        return view('videos', $dados);
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
        $dados['dados']     = Video::findOrFail($id);
        return view('video', $dados);
    }
}
