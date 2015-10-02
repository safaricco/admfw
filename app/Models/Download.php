<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table        = 'downloads';
    protected $fillable     = ['descricao' ,'link' ,'imagem' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_download';
}
