<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parceiro extends Model
{
    protected $table        = 'parceiros';
    protected $fillable     = ['nome' ,'link' ,'logo' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_parceiro';
}
