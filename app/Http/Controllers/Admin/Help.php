<?php

namespace App\Http\Controllers\Admin;

use App\Models\Helps;
use App\Models\Midia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\BinaryOp\Mul;

class Help extends Controller
{
    public $tipo_midia = 21;

    public function __construct()
    {
        LogR::register(last(explode('\\', get_class($this))) . ' ' . explode('@', Route::currentRouteAction())[1]);
    }

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

            $ajuda          = new Helps();

            $ajuda->titulo  = $request->titulo;
            $ajuda->icone   = $request->icone;
            $ajuda->texto   = Midia::uploadTextarea($request->texto, $this->tipo_midia);

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
            $ajuda->texto   = Midia::uploadTextarea($request->texto, $this->tipo_midia);
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
