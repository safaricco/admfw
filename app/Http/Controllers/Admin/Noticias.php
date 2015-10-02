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

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                $midia                      = new Midia();
                $midia->id_tipo_midia       = $this->tipo_midia;
                $midia->id_registro_tabela  = $noticia->id_noticia;
                $midia->descricao           = $nomeTipo . ' criado automaticamente';
                $midia->save();

                foreach ($request->file('imagens') as $img) :

                    $nomeOriginal   = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = new Multimidia();                                                         // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();

                endforeach;

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

            // FAZENDO O UPLOAD E GRAVANDO NA TABELA MULTIMIDIA / VERIFICANDO SE O ARQUIVO NÃO ESTÁ CORROMPIDO
            if ($request->hasFile('imagens')) :

                $nomeTipo   = TipoMidia::findOrFail($this->tipo_midia)->descricao;                                                // A VARIÁVEL $nomeTipo CONTÉM O NOME DO TIPO DA MIDIA E SERÁ USADA COMO NOME DA PASTA DENTRO DA PASTA UPLOADS

                $midia      = Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first();

                if (count($midia) < 1) :

                    // CRIANDO O REGISTRO PAI NA TABELA MIDIA
                    $midia                      = new Midia();
                    $midia->id_tipo_midia       = $this->tipo_midia;
                    $midia->id_registro_tabela  = $noticia->id_noticia;
                    $midia->descricao           = $nomeTipo . ' criado automaticamente';
                    $midia->save();

                endif;

                foreach ($request->file('imagens') as $img) :

                    $nomeOriginal   = $img->getClientOriginalName();                                            // PEGANDO O NOME ORIGINAL DO ARQUIVO A SER UPADO

                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $img->getClientOriginalExtension();    // MONTANDO O NOVO NOME COM MD5 + IDUNICO BASEADO NO NOME ORIGINAL E CONCATENANDO COM A EXTENÇÃO DO ARQUIVO

                    $img->move('uploads/' . $nomeTipo, $novoNome);                                              // MOVENDO O ARQUIVO PARA A PASTA UPLOADS/"TIPO DA MIDIA"

                    $imagem         = Multimidia::where('id_midia', $midia->id_midia);

                    if (isset($imagem))
                        $imagem = new Multimidia();

                    // GRAVANDO NA TABELA MULTIMIDIA

                    // PREPARANDO DADOS PARA GRAVAR NA TABELA MULTIMIDIA
                    $imagem->id_midia   = $midia->id_midia;
                    $imagem->imagem     = $novoNome;
                    $imagem->ordem      = $request->ordem;
                    $imagem->video      = $request->video;

                    $imagem->save();

                endforeach;

            endif;
            
            session()->flash('flash_message', 'Noticia alterada com sucesso!');

            return Redirect::back();
        endif; 
    }


    public function destroy($id)
    {
        Midia::excluir($id);

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
