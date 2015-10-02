<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    protected $table        = 'servicos';
    protected $fillable     = ['id_subcategoria' ,'ref' ,'nome' ,'descricao' ,'status'];
    protected $primaryKey   = 'id_servico';
}
