<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table        = 'configuracao';
    protected $fillable     = ['logo' , 'logo_footer' ,'nome_site'];
    protected $primaryKey   = 'id_configuracao';
}
