<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class Produto extends Controller
{
    public $tipo_midia      = 12;
    public $tipo_categoria  = 1;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin/produtos/produtos', ['produtos' => Produtos::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dados['put']           = false;
        $dados['dados']         = '';
        $dados['route']         = 'admin/produtos/store';
        $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
        return view('admin/produtos/dados', $dados);
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
        $idMidia                = collect(Midia::where('id_registro_tabela', $id)->where('id_tipo_midia', $this->tipo_midia)->first())->first();

        if (!empty($idMidia->id_midia)) :
            $dados['imagens']   = Midia::find($idMidia->id_midia)->multimidia()->where('id_midia', $idMidia->id_midia)->get();
            $dados['destacada'] = Midia::findOrFail($idMidia->id_midia);
        else :
            $dados['imagens']   = '';
            $dados['destacada'] = '';
        endif;

        $dados['put']           = true;
        $dados['dados']         = Produtos::findOrFail($id);
        $dados['route']         = 'admin/produtos/atualizar/'.$id;
        $dados['subcategorias'] = Subcategoria::subs($this->tipo_categoria);
        return view('admin/produtos/dados', $dados);
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
        Midia::excluir($id, $this->tipo_midia);

        Produtos::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return Redirect::back();
    }

    public function updateStatus($status, $id)
    {
        $dado         = Produtos::findOrFail($id);

        $dado->status = $status;

        $dado->save();

        session()->flash('flash_message', 'Status alterado com sucesso!');

        return Redirect::back();
    }
}
