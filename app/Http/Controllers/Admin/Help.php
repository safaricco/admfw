<?php

namespace App\Http\Controllers\Admin;

use App\Models\Helps;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\BinaryOp\Mul;

class Help extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['itens'] = Helps::all();
        return view('admin/ajuda/ajuda', $dados);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
        $dados['itens'] = Helps::all();
        return view('admin/ajuda/listar', $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados['put']           = false;
        $dados['dados']         = '';
        $dados['route']         = 'admin/ajuda/store';
        return view('admin/ajuda/dados', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'icone'     => 'required|string',
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
        ]);

        if ($validation->fails()) :
            return redirect('admin/ajuda/novo')->withErrors($validation)->withInput();
        else :

            $ajuda = new Helps();

            $ajuda->titulo  = $request->titulo;
            $ajuda->icone   = $request->icone;

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
                    $filepath = "uploads/ajuda/".$filename.'.'.$mimetype;

                    // @see http://image.intervention.io/api/
                    $image = Image::make($src)
                        ->encode($mimetype, 100) 	// encode file to the specified mimetype
                        ->save(public_path($filepath));

                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);

                endif;

            endforeach;

            $ajuda->texto = $dom->saveHTML();

            $ajuda->save();

            session()->flash('flash_message', 'Item de ajuda cadastrado com sucesso!');

            return Redirect::back();

        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados['dados'] = Helps::findOrFail($id);
        return view('admin/ajuda/visualizar', $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados['put']   = true;
        $dados['dados'] = Helps::findOrFail($id);
        $dados['route'] = 'admin/ajuda/atualizar/'.$id;

        return view('admin/ajuda/dados', $dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'icone'     => 'required|string',
            'titulo'    => 'required|string',
            'texto'     => 'required|string',
        ]);

        if ($validation->fails()) :
            return redirect('admin/adjua/editar/'.$id)->withErrors($validation)->withInput();
        else :

            $ajuda = Helps::findOrFail($id);

            $ajuda->titulo  = $request->titulo;
            $ajuda->icone   = $request->icone;


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
                    $filepath = "uploads/ajuda/".$filename.'.'.$mimetype;

                    // @see http://image.intervention.io/api/
                    $image = Image::make($src)
                        ->encode($mimetype, 100) 	// encode file to the specified mimetype
                        ->save(public_path($filepath));

                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);

                endif;

            endforeach;

            $ajuda->texto = $dom->saveHTML();

            $ajuda->save();

            session()->flash('flash_message', 'Item de ajuda alterado com sucesso!');

            return Redirect::back();
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Helps::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }
}
