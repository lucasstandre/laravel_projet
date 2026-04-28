<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $primaryKey = 'id_pays';
    protected $fillable = ['pays'];
    public $timestamps = false;

}
