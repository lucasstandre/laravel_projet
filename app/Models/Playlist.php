<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playlist extends Model
{
    use HasFactory;
    protected $table = 'playlists';
    protected $primaryKey = 'id_playlist';
    public $timestamps = false;
    protected $fillable = ['id_creator', 'playlist', 'description', 'link', 'original'];
    public function user(): BelongsTo
    {
    // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
    return $this->belongsTo(User::class, 'id_creator');
    }
}
