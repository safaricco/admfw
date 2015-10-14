<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\BinaryOp\Mul;

class Noticias extends Controller
{
    public $tipo_midia      = 10;
    public $tipo_categoria  = 3;
    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    public function index()
    {
        try {
            $dados['noticias'] = Noticia::all();
            return view('admin/noticias/noticias', $dados);

        } catch (\Exception $e) {

            LogR::exception('index noticias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function create()
    {
        try {
            $dados['put']           = false;
            $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
            $dados['dados']         = '';
            $dados['route']         = 'admin/noticias/store';
            return view('admin/noticias/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('create noticias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_subcategoria'   => 'required|integer',
            'titulo'            => 'required|string',
            'resumo'            => 'string',
            'texto'             => 'required|string',
            'destaque'          => 'required|string',
            'tags'              => 'string',
            'data'              => 'date',
            'imagens[]'         => 'mimes:jpeg,bmp,png,jpg',
            'imagem'            => 'mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/noticias/novo')->withErrors($validation)->withInput();
        else :

            try {
                $noticia = new Noticia();

                $noticia->id_subcategoria   = $request->id_subcategoria;
                $noticia->titulo            = $request->titulo;
                $noticia->resumo            = $request->resumo;
                $noticia->tags              = $request->tags;
                $noticia->autor             = Auth::user()->name;
                $noticia->slug              = str_slug($request->titulo);
                $noticia->texto             = Midia::uploadTextarea($request->texto, $this->tipo_midia);
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

            } catch (\Exception $e) {

                LogR::exception($noticia, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    public function show($id)
    {
        try {
            $dados['imagens']       = Midia::imagens($this->tipo_midia, $id);
            $dados['destacada']     = Midia::destacada($this->tipo_midia, $id);

            $dados['put']           = true;
            $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
            $dados['dados']         = Noticia::findOrFail($id);
            $dados['route']         = 'admin/noticias/atualizar/'.$id;

            return view('admin/noticias/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show noticias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
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
             'resumo'            => 'string',
             'texto'             => 'required|string',
             'destaque'          => 'required|string',
             'tags'              => 'string',
             'data'              => 'date',
             'imagens[]'         => 'mimes:jpeg,bmp,png,jpg',
             'imagem'            => 'mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validation->fails()) :
            return redirect('admin/noticias/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $noticia                    = Noticia::findOrFail($id);

                $noticia->id_subcategoria   = $request->id_subcategoria;
                $noticia->titulo            = $request->titulo;
                $noticia->resumo            = $request->resumo;
                $noticia->tags              = $request->tags;
                $noticia->autor             = Auth::user()->name;
                $noticia->slug              = str_slug($request->titulo);
                $noticia->texto             = Midia::uploadTextarea($request->texto, $this->tipo_midia);
                $noticia->save();

                if ($request->hasFile('imagem')) :

                    Midia::uploadDestacada($this->tipo_midia, $noticia->id_noticia);

                endif;

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $noticia->id_noticia);

                endif;

                session()->flash('flash_message', 'Noticia alterada com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($noticia, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }
            return Redirect::back();
        endif; 
    }


    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Noticia::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');

        } catch (\Exception $e) {

            LogR::exception('destroy noticias', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Noticia::findOrFail($id);

            $dado->status = $status;

            $dado->save();

            session()->flash('flash_message', 'Status alterado com sucesso!');

        } catch (\Exception $e) {

            LogR::exception($dado, $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }
}
