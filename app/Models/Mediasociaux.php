<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaSocial extends Model
{
    protected $fillable = ['nom', 'url', 'icone', 'actif'];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
