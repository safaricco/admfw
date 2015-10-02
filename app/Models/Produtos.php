<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produtos extends Model
{
    protected $table        = 'produtos';
    protected $fillable     = ['idSubcategoria', 'nome', 'imagem', 'descricao','ref','imagem', 'status'];
    protected $primaryKey   = 'id_produto';

}
