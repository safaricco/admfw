<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    protected $table        = 'analytics';
    protected $fillable     = ['codigo'];
    protected $primaryKey   = 'id_analytics';
}
