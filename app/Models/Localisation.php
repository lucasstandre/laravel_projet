<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $table = 'localisations';
    protected $primaryKey = 'id_localisation';
    protected $fillable = ['localisation', 'id_pays'];
    public $timestamps = false;
}
