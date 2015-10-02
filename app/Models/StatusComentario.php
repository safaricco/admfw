<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusComentario extends Model
{
    protected $table        = 'status_comentario';
    protected $fillable     = ['nome' , 'status'];
    protected $primaryKey   = 'id_status_comentario';
}
