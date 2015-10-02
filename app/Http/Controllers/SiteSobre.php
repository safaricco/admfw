<?php

namespace App\Http\Controllers;

use App\Models\Midia;
use App\Models\Sobres;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteSobre extends Controller
{
    public $tipo_midia = 16;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idMidia            = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first()->id_midia;
        $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        $dados['dados']     = Sobres::all();
        return view('sobre', $dados);
    }
}
