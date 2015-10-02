<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table        = 'fotos';
    protected $fillable     = ['titulo' ,'texto' ,'link' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_foto';
}
