<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patrocinador extends Model
{
    protected $table        = 'patrocinador';
    protected $fillable     = ['nome' ,'link' ,'logo' ,'ordem' ,'status'];
    protected $primaryKey   = 'id_patrocinador';
}
