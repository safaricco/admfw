<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Midia;
use App\Models\Noticia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteNoticias extends Controller
{
    public $tipo_midia = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticia            = Noticia::where('status', '=', 1)->paginate(3);
        $dados['imagens']   = Midia::where('id_tipo_midia', '=', $this->tipo_midia)->get();
        $dados['noticias']  = $noticia;
        return view('site/noticias', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comentario(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id)
    {
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first())->first();

        if (!empty($idMidia)) :
            $dados['imagens']   = Midia::find($idMidia)->multimidia()->where('id_midia', $idMidia)->get();
        else :
            $dados['imagens']   = '';
        endif;


        $dados['destacada']     = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();
        $dados['blog']          = Noticia::where('slug',$slug)->first();
        return view('site/noticias-page', $dados);
    }

    public function categoria($idCategoria)
    {
        $noticia            = Categoria::find($idCategoria)->noticias()->paginate(3);
        $dados['imagens']   = Midia::where('id_tipo_midia', '=', $this->tipo_midia)->get();
        $dados['noticias']  = $noticia;

        return view('site/noticias', $dados);
    }
}
