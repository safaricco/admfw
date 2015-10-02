<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Mail;

class Emails extends Model
{
    protected $table        = 'emails';
    protected $fillable     = ['protocolo' ,'host' ,'porta' ,'endereco' ,'senha' ,'status'];
    protected $primaryKey   = 'id_email';

    public static function enviarEmail($assunto, $remetente, $destinatario, $dados, $view, $copia = null)
    {
        Mail::send($view, $dados, function ($message) use ($remetente, $destinatario, $copia, $assunto) {
            #$message->from('us@example.com', 'Laravel');

            #$message->to('foo@example.com')->cc('bar@example.com');

            $message->from($remetente, $name = null);
            $message->sender($remetente, $name = null);
            $message->to($destinatario, $name = null);

            if ($copia) $message->bcc($copia, $name = null);

            $message->subject($assunto);
        });
    }

    public static function sendRecuperar($senha, $email)
    {
        $confsite       = Configuracao::find(1);

        $assunto        = '['.$confsite->nome_site.'] Recuperação de senha';
        $remetente      = 'noreply@safaricomunicacao.com.br';
        $destinatario   = $email;

        $dados = array(
            'usuario'   => $email,
            'senha'     => $senha,
            'hora'      => date('d/m/Y H:m:i')
        );

        $view = 'admin.static.emails.recuperar-senha';

        Emails::enviarEmail($assunto, $remetente, $destinatario, $dados, $view);
    }
}
