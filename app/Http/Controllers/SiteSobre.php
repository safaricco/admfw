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
        $dados['dados']     = Sobres::findOrFail(1);
        return view('site/sobre', $dados);
    }
}
