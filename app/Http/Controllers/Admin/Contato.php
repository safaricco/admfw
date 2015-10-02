<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contatos;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Contato extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['dados'] = Contatos::findOrFail(1);
        $dados['route'] = '/admin/configuracoes/contato/editar/1';
        $dados['put']   = true;
        return view('admin/contato/contato', $dados);
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

            return redirect('admin/configuracoes/contato');

        endif;
    }
}
