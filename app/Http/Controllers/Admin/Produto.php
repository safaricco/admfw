<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogR;
use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\Produtos;
use App\Models\Subcategoria;
use App\Models\TipoMidia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class Produto extends Controller
{
    public $tipo_midia      = 12;
    public $tipo_categoria  = 1;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {
            return view('admin/produtos/produtos', ['produtos' => Produtos::all()]);
        } catch (\Exception $e) {

            LogR::exception('index produto', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $dados['put']           = false;
            $dados['dados']         = '';
            $dados['route']         = 'admin/produtos/store';
            $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
            return view('admin/produtos/dados', $dados);
        } catch (\Exception $e) {

            LogR::exception('create produto', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            return Redirect::back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nome'              => 'required|string|unique:produtos',
            'descricao'         => 'string',
            'ref'               => 'string|unique:produtos',
            'idSubcategoria'    => 'required|integer',
            'imagens[]'         => 'image|mimes:jpg,png,jpeg,gif',
            'imagem'            => 'image|mimes:jpg,png,jpeg,gif'
        ]);
        if ($validation->fails()) :
            return redirect('admin/produtos/novo')->withErrors($validation)->withInput();
        else :

            try {
                $produto = new Produtos();

                $produto->nome              = $request->nome;
                $produto->descricao         = $request->descricao;
                $produto->ref               = $request->ref;
                $produto->idSubcategoria    = $request->idSubcategoria;

                $produto->save();

                if ($request->hasFile('imagem')) :

                    Midia::uploadDestacada($this->tipo_midia, $produto->id_produto);

                endif;

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $produto->id_produto);

                endif;

                session()->flash('flash_message', 'Produto cadastrado com sucesso!');

                return Redirect::back();

            } catch (\Exception $e) {

                LogR::exception($produto, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $dados['imagens']       = Midia::imagens($this->tipo_midia, $id);
            $dados['destacada']     = Midia::destacada($this->tipo_midia, $id);
            $dados['put']           = true;
            $dados['dados']         = Produtos::findOrFail($id);
            $dados['route']         = 'admin/produtos/atualizar/'.$id;
            $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
            return view('admin/produtos/dados', $dados);

        } catch (\Exception $e) {

            LogR::exception('show produto', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'nome'              => 'required|string',
            'descricao'         => 'string',
            'ref'               => 'string',
            'idSubcategoria'    => 'required|integer',
            'imagens[]'         => 'image|mimes:jpg,png,jpeg,gif',
            'imagem'            => 'image|mimes:jpg,png,jpeg,gif'
        ]);
        if ($validation->fails()) :
            return redirect('admin/produtos/editar/'.$id)->withErrors($validation)->withInput();
        else :

            try {
                $produto = Produtos::findOrFail($id);

                $produto->nome              = $request->nome;
                $produto->descricao         = $request->descricao;
                $produto->ref               = $request->ref;
                $produto->idSubcategoria    = $request->idSubcategoria;

                $produto->save();

                if ($request->hasFile('imagem')) :

                    Midia::uploadDestacada($this->tipo_midia, $produto->id_produto);

                endif;

                if ($request->hasFile('imagens')) :

                    Midia::uploadMultiplo($this->tipo_midia, $produto->id_produto);

                endif;

                session()->flash('flash_message', 'Produto alterado com sucesso!');

            } catch (\Exception $e) {

                LogR::exception($produto, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }

            return Redirect::back();

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Midia::excluir($id, $this->tipo_midia);

            Produtos::destroy($id);

            session()->flash('flash_message', 'Registro apagado com sucesso');
        } catch (\Exception $e) {

            LogR::exception('destroy produto', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

        }

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        try {
            $dado         = Produtos::findOrFail($id);

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
