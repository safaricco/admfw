<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dica extends Model
{
    protected $table        = 'dicas';
    protected $fillable     = ['titulo' , 'texto' ,'data' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_dica';
}
