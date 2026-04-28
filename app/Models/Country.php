<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'id_country';
    public $timestamps = false;
        protected $fillable = [
                'name_country',
                'code',
            ]; // pour les code
}
