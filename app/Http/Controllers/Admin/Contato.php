<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contatos;
use App\Models\LogR;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


class Contato extends Controller
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
        try {

            $dados['dados'] = Contatos::findOrFail(1);
            $dados['route'] = '/admin/configuracoes/contato/editar/1';
            $dados['put']   = true;

            return view('admin/contato/contato', $dados);

        } catch (\Exception $e) {

            LogR::exception('index contato', $e);
            session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());
            return Redirect::back();
        }
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
            'email'         => 'string',
            'telefone'      => 'string',
            'rua'           => 'string',
            'bairro'        => 'string',
            'cidade'        => 'string',
            'estado'        => 'string',
            'numero'        => 'string',
            'cep'           => 'string',
            'complemento'   => 'string',
            'latitude'      => 'string',
            'longitude'     => 'string',
            'facebook'      => 'string',
            'googleplus'    => 'string',
            'twitter'       => 'string',
            'instagran'     => 'string',

        ]);

        if ($validacao->fails()) :
            return redirect('admin/configuracoes/contato')->withErrors($validacao)->withInput();
        else :

            try {

                $contato                = Contatos::findOrFail($id);

                $contato->email         = $request->email;
                $contato->telefone      = $request->telefone;
                $contato->rua           = $request->rua;
                $contato->bairro        = $request->bairro;
                $contato->cidade        = $request->cidade;
                $contato->estado        = $request->estado;
                $contato->numero        = $request->numero;
                $contato->cep           = $request->cep;
                $contato->complemento   = $request->complemento;
                $contato->latitude      = $request->latitude;
                $contato->longitude     = $request->longitude;
                $contato->facebook      = $request->facebook;
                $contato->googleplus    = $request->googleplus;
                $contato->twitter       = $request->twitter;
                $contato->instagran     = $request->instagran;

                $contato->save();

                session()->flash('flash_message', 'Registro atualizado com sucesso!');
            } catch (\Exception $e) {

                LogR::exception($contato, $e);
                session()->flash('flash_message', 'Ops!! Ocorreu algum problema!. ' . $e->getMessage());

            }
            return Redirect::back();

        endif;
    }
}
