<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaSocial extends Model
{
    protected $fillable = ['user_id', 'nom', 'url', 'icone', 'actif'];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
