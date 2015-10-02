<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $table        = 'comentarios';
    protected $fillable     = ['id_noticia' , 'id_status_comentario' ,'nome' ,'email' ,'texto'];
    protected $primaryKey   = 'id_comentario';
}
