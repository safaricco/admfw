<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    protected $table        = 'contatos';
    protected $fillable     = ['email' , 'telefone' ,'rua' ,'bairro' ,'cidade' ,'estado' ,'numero','cep','complemento','latitude','longitude' ,'facebook' ,'googleplus' ,'twitter' ,'instagran' ,'email_recebe_formulario'];
    protected $primaryKey   = 'id_contato';
}
