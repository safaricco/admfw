<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destaque extends Model
{
    protected $table        = 'destaques';
    protected $fillable     = ['nome' , 'data' ,'hora' ,'profissional'];
    protected $primaryKey   = 'id_destaques';
}
