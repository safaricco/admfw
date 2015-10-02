<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depoimentos extends Model
{
    protected $table        = 'depoimentos';
    protected $fillable     = ['nome' , 'texto' ,'video' ,'status'];
    protected $primaryKey   = 'id_depoimento';
}
