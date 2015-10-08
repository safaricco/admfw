<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\Depoimentos;
use App\Models\Evento;
use App\Models\Foto;
use App\Models\Midia;
use App\Models\Noticia;
use App\Models\Produtos;
use App\Models\Servicos;
use App\Models\Sobres;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteHome extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $data['banners']        = Banner::banners();
//        $data['depoimentos']	= Depoimentos::where('status',1)->get();
//        $data['noticias'] 		= collect(Noticia::todas())->take(2);
//        $data['servicos'] 		= Servicos::where('status',1)->get();;
//        $data['produtos'] 		= collect(Produtos::selecionarProdutosWS())->take(10);
//        $data['sobre'] 	        = Sobres::findOrFail(1);
//        return view('site/index', $data);
        return view('welcome');
    }
}
