<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sobres extends Model
{
    protected $table        = 'sobre';
    protected $fillable     = ['tiutlo', 'texto'];
    protected $primaryKey   = 'id_sobre';
}
