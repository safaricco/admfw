<?php

namespace App\Http\Controllers\Admin;

use App\Models\Analytics;
use App\Models\LogR;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Analytic extends Controller
{
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
        $dados['dados'] = Analytics::findOrFail(1);
        $dados['route'] = '/admin/configuracoes/analytics/editar/1';
        $dados['put']   = true;
        return view('admin/analytics/analytics', $dados);
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
        $validacao = Validator::make($request->all(), [
            'codigo' => 'required|string'
        ]);

        if ($validacao->fails()) :
            return redirect('admin/configuracoes/analytics')->withErrors($validacao)->withInput();
        else :

            $analytic           = Analytics::find($id);

            $analytic->codigo   = $request->codigo;

            $analytic->save();

            session()->flash('flash_message', 'Registro atualizado com sucesso!');

            return redirect('admin/configuracoes/analytics');

        endif;
    }
}
