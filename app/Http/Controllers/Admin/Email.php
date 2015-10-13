<?php

namespace App\Http\Controllers\Admin;

use App\Models\Emails;
use App\Models\LogR;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Email extends Controller
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
        $dados['dados'] = Emails::findOrFail(1);
        $dados['route'] = '/admin/configuracoes/email/editar/1';
        $dados['put']   = true;
        return view('admin/email/emails', $dados);
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
            'protocolo' => 'required|string',
            'host'      => 'required|string',
            'porta'     => 'required|integer',
            'endereco'  => 'required|email',
            'senha'     => 'password'
        ]);

        if ($validacao->fails()) :
            return redirect('admin/configuracoes/email')->withErrors($validacao)->withInput();
        else :

            $email           = Emails::find($id);

            $email->protocolo    = $request->protocolo;
            $email->host         = $request->host;
            $email->porta        = $request->porta;
            $email->endereco     = $request->endereco;

            if (!empty($request->senha))
                $email->senha = bcrypt($request->senha);

            $email->save();

            session()->flash('flash_message', 'Registro atualizado com sucesso!');

            return Redirect::back();

        endif;
    }
}
