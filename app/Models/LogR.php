<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LogR extends Model
{
    protected $table        = 'log';
    protected $fillable     = ['tipo', 'site', 'dominio', 'sistema_operacional', 'navegador', 'ip', 'usuario', 'url', 'resolucao_tela', 'mensagem', 'arquivo', 'codigo_erro', 'trace_string'];
    protected $primaryKey   = 'id_log';

    public static function register()
    {

    }

    public static function exception()
    {
        LogR::getBrowser();
    }











    public static function getBrowser()
    {
        return Request::capture()->server('HTTP_USER_AGENT');
    }

    public static function getDados()
    {
        return Request::capture()->reque('HTTP_USER_AGENT');
    }

    public static function getUrl()
    {
        return Request::capture()->url();
    }

    public static function getDestino()
    {
        return Request::capture()->decodedPath();
    }

    public static function getMethod()
    {
        return Request::capture()->method();
    }

    public static function getIp()
    {
        return Request::capture()->ip();
    }

}

/*






"PATH" => "/sbin:/usr/sbin:/bin:/usr/bin:/usr/X11R6/bin"
  "PWD" => "/usr/local/cpanel/cgi-sys"
  "SHLVL" => "0"
  "PHP_FCGI_MAX_REQUESTS" => "5000"
  "SCRIPT_NAME" => "/index.php"
  "REQUEST_URI" => "/asd"
  "QUERY_STRING" => ""
  "REQUEST_METHOD" => "GET"
  "SERVER_PROTOCOL" => "HTTP/1.1"
  "GATEWAY_INTERFACE" => "CGI/1.1"
  "REDIRECT_URL" => "/asd"
  "REMOTE_PORT" => "8663"
  "SCRIPT_FILENAME" => "/home/safaribr/public_html/ws/public/index.php"
  "SERVER_ADMIN" => "webmaster@ws.safaricomunicacao.com.br"
  "CONTEXT_DOCUMENT_ROOT" => "/home/safaribr/public_html/ws/public"
  "CONTEXT_PREFIX" => ""
  "REQUEST_SCHEME" => "http"
  "DOCUMENT_ROOT" => "/home/safaribr/public_html/ws/public"
  "REMOTE_ADDR" => "177.10.167.21"
  "SERVER_PORT" => "80"
  "SERVER_ADDR" => "107.180.21.55"
  "SERVER_NAME" => "ws.safaricomunicacao.com.br"
  "SERVER_SOFTWARE" => "Apache/2.4.12"
  "SERVER_SIGNATURE" => ""
  "HTTP_CACHE_CONTROL" => "max-age=0"
  "HTTP_CONNECTION" => "close"
  "HTTP_ACCEPT_LANGUAGE" => "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3"*/
//  "HTTP_ACCEPT" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
/*"HTTP_USER_AGENT" => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:41.0) Gecko/20100101 Firefox/41.0"
  "HTTP_HOST" => "ws.safaricomunicacao.com.br"
  "UNIQUE_ID" => "VhgY58ZH5CQABuAUVLUAAAHR"
  "REDIRECT_STATUS" => "200"
  "REDIRECT_UNIQUE_ID" => "VhgY58ZH5CQABuAUVLUAAAHR"
  "FCGI_ROLE" => "RESPONDER"
  "PHP_SELF" => "/index.php"
  "REQUEST_TIME_FLOAT" => 1444419815.7782
  "REQUEST_TIME" => 1444419815
  "APP_ENV" => "local"
  "APP_DEBUG" => "true"
  "APP_KEY" => "psLYd6SEdjh1eKmEpzIGMpKMQOvibmoc"
  "DB_HOST" => "localhost"
  "DB_DATABASE" => "boxcidade"
  "DB_USERNAME" => "root"
  "DB_PASSWORD" => ""
  "DB_BOX_HOST" => "localhost"
  "DB_BOX_DATABASE" => "boxcidade"
  "DB_BOX_USERNAME" => "root"
  "DB_BOX_PASSWORD" => ""
  "CACHE_DRIVER" => "file"
  "SESSION_DRIVER" => "file"
  "QUEUE_DRIVER" => "sync"
  "MAIL_DRIVER" => "smtp"
  "MAIL_HOST" => "mailtrap.io"
  "MAIL_PORT" => "2525"
  "MAIL_USERNAME" => "null"
  "MAIL_PASSWORD" => "null"
  "MAIL_ENCRYPTION" => "null"












 * */


