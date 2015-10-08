<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helps extends Model
{
    protected $table        = 'ajuda';
    protected $fillable     = ['icone', 'titulo' ,'texto' , 'status'];
    protected $primaryKey   = 'id_ajuda';
}
