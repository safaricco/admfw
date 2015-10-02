<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table        = 'banners';
    protected $fillable     = ['titulo' ,'texto' ,'link' ,'data_inicio' ,'data_final' ,'status'];
    protected $primaryKey   = 'id_banner';
}
