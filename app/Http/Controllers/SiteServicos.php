<?php

namespace App\Http\Controllers;

use App\Models\Servicos;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteServicos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['servicos'] = Servicos::all();
        return view('site/servicos', $dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados['servico']   = Servicos::findOrFail($id);
        $dados['imagens']   = Servicos::servicoFoto($id);
        return view('site/servicos-page', $dados);
    }
}
