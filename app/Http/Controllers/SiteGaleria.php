<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Midia;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteGaleria extends Controller
{
    public $tipo_midia = 8;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $dados['dados']     = Video::all();
        $dados['fotos']     = Foto::where('status', '=', 1)->get();
        $dados['imagens']   = Midia::where('id_tipo_midia', '=', $this->tipo_midia)->get();
        return view('site/galeria', $dados);
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
        $dados['galeria']       = Foto::findOrFail($id);
        return view('site/galeria-page', $dados);
    }
}
