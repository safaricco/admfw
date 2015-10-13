<?php

namespace App\Http\Controllers\Admin;

use App\Models\Configuracao;
use App\Models\LogR;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Configuracoes extends Controller
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
        $dados['dados'] = Configuracao::findOrFail(1);
        $dados['route'] = '/admin/configuracoes/site/editar/1';
        $dados['put']   = true;
        return view('admin/configuracao/site', $dados);
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
            'nome_site'     => 'required|string',
            'logo'          => 'image|mimes:jpg,jpeg,png,gif',
            'logo_footer'   => 'image|mimes:jpg,jpeg,png,gif'
        ]);

        if ($validacao->fails()) :
            return redirect('admin/configuracoes/site')->withErrors($validacao)->withInput();
        else :

            $config                 = Configuracao::find($id);

            $config->nome_site      = $request->nome_site;

            if ($request->hasFile('logo')) :

                if ($request->file('logo')->isValid()) :

                    $nomeOriginal   = $request->file('logo')->getClientOriginalName();
                    $novoNome       = md5(uniqid($nomeOriginal)) . '.' . $request->file('logo')->getClientOriginalExtension();

                    $request->file('logo')->move('uploads/logo', $novoNome);

                    $config->logo   = $novoNome;

                endif;
            endif;

            if ($request->hasFile('logo_footer')) :

                if ($request->file('logo_footer')->isValid()) :

                    $nomeOriginal           = $request->file('logo_footer')->getClientOriginalName();
                    $novoNome               = md5(uniqid($nomeOriginal)) . '.' . $request->file('logo_footer')->getClientOriginalExtension();

                    $request->file('logo_footer')->move('uploads/logo', $novoNome);

                    $config->logo_footer    = $novoNome;

                endif;
            endif;

            $config->save();

            session()->flash('flash_message', 'Registro atualizado com sucesso!');

            return Redirect::back();

        endif;
    }
}
