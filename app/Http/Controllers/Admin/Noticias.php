<?php

namespace App\Http\Controllers\Admin;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\Subcategoria;
use App\Models\TipoCategoria;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\Categoria;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\BinaryOp\Mul;

class Noticias extends Controller
{
    public $tipo_midia      = 10;
    public $tipo_categoria  = 3;

    public function index()
    {
        $dados['noticias'] = Noticia::all();
        return view('admin/noticias/noticias', $dados);
    }

    public function create()
    {
        $dados['put']           = false;
        $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
        $dados['dados']         = '';
        $dados['route']         = 'admin/noticias/store';
        return view('admin/noticias/dados', $dados);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_subcategoria'   => 'required|integer',
            'titulo'            => 'required|string',
            'texto'             => 'required|string',
            'destaque'          => 'required|string',
            'data'              => 'date',
            'imagens[]'         => 'mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/noticias/novo')->withErrors($validation)->withInput();
        else :

            $noticia = new Noticia();

            $noticia->id_subcategoria   = $request->id_subcategoria;
            $noticia->titulo            = $request->titulo;
//            $noticia->texto             = $request->texto;

            // gravando imagem do corpo da noticia
            $dom = new \DOMDocument();
            $dom->loadHtml($request->texto, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            // TODO fazer gravar as imagens do editor nas tabelas midia e multimia
            // foreach <img> in the submited message
            foreach($images as $img) :
                $src = $img->getAttribute('src');

                // if the img source is 'data-url'
                if(preg_match('/data:image/', $src)) :

                    // get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];

                    // Generating a random filename
                    $filename = md5(uniqid());
                    $filepath = "uploads/noticias/".$filename.'.'.$mimetype;

                    // @see http://image.intervention.io/api/
                    $image = Image::make($src)
                        ->encode($mimetype, 100) 	// encode file to the specified mimetype
                        ->save(public_path($filepath));

                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);

                endif;

            endforeach;

            $noticia->texto = $dom->saveHTML();

            $noticia->destaque          = $request->destaque;
            $noticia->data              = date('Y-m-d');

            $noticia->save();

            if ($request->hasFile('imagem')) :

                Midia::uploadDestacada($this->tipo_midia, $noticia->id_noticia);

            endif;

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $noticia->id_noticia);

            endif;

            session()->flash('flash_message', 'Noticia cadastrada com sucesso!');

            return Redirect::back();

        endif;
    }

    public function show($id)
    {
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first())->first();

        if (!empty($idMidia->id_midia)) :
            $dados['imagens']   = Midia::find($idMidia->id_midia)->multimidia()->where('id_midia', $idMidia->id_midia)->get();
            $dados['destacada'] = Midia::findOrFail($idMidia->id_midia);
        else :
            $dados['imagens']   = '';
            $dados['destacada'] = '';
        endif;

        $dados['put']           = true;
        $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
        $dados['dados']         = Noticia::findOrFail($id);
        $dados['route']         = 'admin/noticias/atualizar/'.$id;

        return view('admin/noticias/dados', $dados);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
         $validation = Validator::make($request->all(), [
             'id_subcategoria'   => 'required|integer',
             'titulo'            => 'required|string',
             'texto'             => 'required|string',
             'destaque'          => 'required|string',
             'imagens[]'         => 'image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/noticias/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $noticia = Noticia::findOrFail($id);

            $noticia->id_subcategoria   = $request->id_subcategoria;
            $noticia->titulo            = $request->titulo;
//            $noticia->texto             = $request->texto;
            $noticia->destaque          = $request->destaque;


            // gravando imagem do corpo da noticia
            $dom = new \DOMDocument();
            $dom->loadHtml($request->texto, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            // TODO fazer autlalizar as imagens do editor nas tabelas midia e multimia
            // foreach <img> in the submited message
            foreach($images as $img) :
                $src = $img->getAttribute('src');

                // if the img source is 'data-url'
                if(preg_match('/data:image/', $src)) :

                    // get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];

                    // Generating a random filename
                    $filename = md5(uniqid());
                    $filepath = "uploads/noticias/".$filename.'.'.$mimetype;

                    // @see http://image.intervention.io/api/
                    $image = Image::make($src)
                        ->encode($mimetype, 100) 	// encode file to the specified mimetype
                        ->save(public_path($filepath));

                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);

                endif;

            endforeach;

            $noticia->texto = $dom->saveHTML();

            $noticia->save();

            if ($request->hasFile('imagem')) :

                Midia::uploadDestacada($this->tipo_midia, $noticia->id_noticia);

            endif;

            if ($request->hasFile('imagens')) :

                Midia::uploadMultiplo($this->tipo_midia, $noticia->id_noticia);

            endif;
            
            session()->flash('flash_message', 'Noticia alterada com sucesso!');

            return Redirect::back();
        endif; 
    }


    public function destroy($id)
    {
        Midia::excluir($id, $this->tipo_midia);

        Noticia::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Noticia::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
