<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class LogR extends Model
{
    protected $table        = 'log';
    protected $fillable     = ['tipo', 'site', 'dominio', 'sistema_operacional', 'navegador', 'ip', 'usuario', 'url', 'resolucao_tela', 'mensagem', 'arquivo', 'codigo_erro', 'trace_string'];
    protected $primaryKey   = 'id_log';

    public static function register($operacao)
    {
        try {

            $log                        = new LogR();

            $log->tipo                  = 'registro';
            $log->operacao              = $operacao;
            $log->status_request        = LogR::status();
            $log->dominio               = url();
            $log->sistema_operacional   = '';
            $log->navegador             = LogR::getBrowser();
            $log->ipUsuario             = LogR::getIp('usuario');
            $log->ipServidor            = LogR::getIp('servidor');
            $log->usuario               = Auth::user()->email;
            $log->urlOrigem             = LogR::getOrigem();
            $log->urlDestino            = LogR::getDestino();
            $log->method                = LogR::getMethod();
            $log->tipo_servidor         = LogR::getTipoServidor();
            $log->ambiente              = LogR::getAmbiente();
            $log->debug                 = LogR::getDegub();
            $log->resolucao_tela        = '';

            $log->save();

            Log::info(collect($log)->toArray());

        } catch(\Exception $e) {

            LogR::exception(['erro' => 'erro de registro'], $e);

        }
    }

    public static function exception($dados, $e = null)
    {
        $confsite                   = Configuracao::findOrFail(1);

        $log                        = new LogR();

        $log->tipo                  = 'exception';
        $log->status_request        = LogR::status();
        $log->site                  = $confsite->nome_site;
        $log->dominio               = url();
        $log->sistema_operacional   = '';
        $log->navegador             = LogR::getBrowser();
        $log->ipUsuario             = LogR::getIp('usuario');
        $log->ipServidor            = LogR::getIp('servidor');
        $log->usuario               = Auth::user()->email;
        $log->urlOrigem             = LogR::getOrigem();
        $log->urlDestino            = LogR::getDestino();
        $log->method                = LogR::getMethod();
        $log->dados                 = implode(' | ', collect($dados)->toArray());
        $log->tipo_servidor         = LogR::getTipoServidor();
        $log->ambiente              = LogR::getAmbiente();
        $log->debug                 = LogR::getDegub();
        $log->banco                 = LogR::getBanco();
        $log->mail_server           = LogR::getMailServer();
        $log->document_root         = LogR::getDocumentRoot();
        $log->resolucao_tela        = '';
        $log->mensagem              = LogR::getExceptionMessage($e);
        $log->arquivo               = LogR::getExceptionFile($e);
        $log->codigo_erro           = LogR::getExceptionCode($e);
        $log->trace_string          = LogR::getExceptionTraceString($e);

        $log->save();

        Log::error($log->toArray());

        $assunto        = '[Houston, We Have a Problem] '. $confsite->nome_site;
        $remetente      = 'noreply@safaricomunicacao.com';
        $destinatario   = 'pablo.safaricco@gmail.com';
//        $destinatario   = 'web@safaricomunicacao.com';

        $dados = array(
            'dados' => $log,
            'hora'  => date('d/m/Y H:m:i')
        );

        $view = 'emails.errorlog';

        Emails::enviarEmail($assunto, $remetente, $destinatario, $dados, $view);

    }

    /*
     * Retorna todas operações e arquivos de erro do exception no formato string
     *
     * */
    public static function getExceptionTraceString($e)
    {
        return $e->getTraceAsString();
    }

    /*
     * Retorna a linha do erro no arquivo da funcao getExceptionFile() de erro do exception
     *
     * EX: "658"
     *
     * */
    public static function getExceptionLine($e)
    {
        return $e->getLine();
    }

    /*
     * Retorna a mensagem de erro do exception
     *
     * EX: "SQLSTATE[42S22]: Column not found: 1054 Unknown column 'tiatulo' in 'field list' (SQL: insert into `banners` (`tiatulo`, `texto`, `link`, `data_inicio`, `updated_at`, `created_at`) values (asd, <p>adsd<br></p>, , 2015-10-09, 2015-10-09 20:47:33, 2015-10-09 20:47:33))"
     *
     * */
    public static function getExceptionMessage($e)
    {
        return $e->getMessage();
    }

    /*
     * Retorna o arquivo onde ocorreu o erro do exception
     *
     * EX: "/var/www/admfw.com.br/vendor/laravel/framework/src/Illuminate/Database/Connection.php"
     *
     * */
    public static function getExceptionFile($e)
    {
        return $e->getFile();
    }

    /*
     * Retorna o código de erro do exception
     *
     * EX: "42S22"
     *
     * */
    public static function getExceptionCode($e)
    {
        return $e->getCode();
    }

    /*
     * Retorna o browser
     *
     * EX: "Mozilla/5.0 (X11; Linux x86_64; rv:43.0) Gecko/20100101 Firefox/43.0"
     * */
    public static function getBrowser()
    {
        return Request::capture()->server('HTTP_USER_AGENT');
    }

    /*
     * Retorna a url de origem
     *
     * "/admin/banners/novo"
     * */
    public static function getOrigem()
    {
        return Request::capture()->url();
    }

    /*
     * Retorna a url de destino
     *
     * "/admin/banners/store"
     * */
    public static function getDestino()
    {
        return Request::capture()->decodedPath();
    }

    /*
     * Retorna o método http
     *
     * get ou post
     * */
    public static function getMethod()
    {
        return Request::capture()->method();
    }

    /*
     * Retorna o IP do servidor ou do cliente
     *
     * @param $tipo     String 'usuario' ou 'servidor'
     * */
    public static function getIp($tipo)
    {
        if ($tipo == 'usuario')
            return Request::capture()->server('REMOTE_ADDR');

        if ($tipo == 'servidor')
            return Request::capture()->server('SERVER_ADDR');
    }

    /*
     * Retorna o tipo do servido
     *
     * "Apache/2.4.7 (Ubuntu)"
     *
     * */
    public static function getTipoServidor()
    {
        return Request::capture()->server('SERVER_SOFTWARE');
    }

    /*
     * Retorna o ambiente de execução
     *
     * local ou produçao
     * */
    public static function getAmbiente()
    {
        return Request::capture()->server('APP_ENV');
    }

    /*
     * Retorna o status do debug
     *
     * true ou false
     * */
    public static function getDegub()
    {
        return Request::capture()->server('APP_DEBUG');
    }

    /*
     * Retorna um array() contendo:
     *
     * "db_host: localhost | db_database: site | db_user: root | db_senha: "
     *
     * */
    public static function getBanco()
    {
        $dados  = 'db_host: '           . Request::capture()->server('DB_HOST');
        $dados .= ' | db_database: '    . Request::capture()->server('DB_DATABASE');
        $dados .= ' | db_user: '        . Request::capture()->server('DB_USERNAME');
        $dados .= ' | db_senha: '       . Request::capture()->server('DB_PASSWORD');

        return $dados;
    }

    /*
     * Retorna uma string contendo:
     *
     * "mail_driver: smtp | mail_host: smtp.safaricomunicacao.com | mail_port: 587 | mail_username: noreply@safaricomunicacao.com | mail_password: cont#9080 | mail_encryption: null"
     *
     */
    public static function getMailServer()
    {
        $dados  = 'mail_driver: '           . Request::capture()->server('MAIL_DRIVER');
        $dados .= ' | mail_host: '          . Request::capture()->server('MAIL_HOST');
        $dados .= ' | mail_port: '          . Request::capture()->server('MAIL_PORT');
        $dados .= ' | mail_username: '      . Request::capture()->server('MAIL_USERNAME');
        $dados .= ' | mail_password: '      . Request::capture()->server('MAIL_PASSWORD');
        $dados .= ' | mail_encryption: '    . Request::capture()->server('MAIL_ENCRYPTION');

        return $dados;
    }

    /*
     * Retorna uma string:
     *
     * "/var/www/admfw.com.br/public"
     *
     * */
    public static function getDocumentRoot()
    {
        return Request::capture()->server('DOCUMENT_ROOT');
    }

    /*
     * Retorna o codigo do http
     *
     * "200", "300"...
     *
     * */
    public static function status()
    {
        return Request::capture()->server('REDIRECT_STATUS');
    }
}