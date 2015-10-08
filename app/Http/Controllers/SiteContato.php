<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Contato;
use App\Models\Configuracao;
use App\Models\Contatos;
use App\Models\Emails;
use App\Models\Midia;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteContato extends Controller
{
    public $tipo_midia = 4;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados['dados']     = Contatos::find(1);
        return view('site.contato', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enviar(Request $request)
    {
        $config     = Configuracao::find(1);
        $contato    = Contato::find(1);
        $email      = Emails::find(1);

        $assunto        = '['. $config->nome_site .'] Contato';
        $remetente      = $email->endereco;
        $destinatario   = $contato->email;

        $dados = array(
            'dados' => $request->all(),
            'hora'  => date('d/m/Y H:m:i')
        );

        $view = 'emails.contato';

        Emails::enviarEmail($assunto, $remetente, $destinatario, $dados, $view, $request->email);
    }
}
