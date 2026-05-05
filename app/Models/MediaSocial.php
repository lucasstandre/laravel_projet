<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaSocial extends Model
{
    protected $fillable = ['user_id', 'nom', 'url', 'icone', 'actif'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
