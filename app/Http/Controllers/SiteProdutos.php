<?php

namespace App\Http\Controllers;

use App\Models\Midia;
use App\Models\Produtos;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteProdutos extends Controller
{
    public $tipo_midia = 12;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['produtos'] = Produtos::selecionarProdutosWS();
        return view('site/produtos', $dados);
    }
}
