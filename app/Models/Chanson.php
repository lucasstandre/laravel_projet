<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Album;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chanson extends Model
{
    use HasFactory;
    protected $table = 'chansons';
    protected $primaryKey = 'id_chanson';
    public $timestamps = false;

    public function user(): BelongsTo
    {
        // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
        return $this->belongsTo(User::class, 'id_artiste');
    }

    public function genre(): BelongsTo
    {
        // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
        return $this->belongsTo(Genre::class, 'id_genre');
    }
    //Manque celui de album
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'id_album');
    }
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'ta_playlist_chanson', 'id_chanson', 'id_playlist');
    }
    public function ecoutes(): HasMany
    {
    // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
    return $this->HasMany(Ecoute::class, 'id_ecoute');
    }
    protected $fillable = [
        'nom',
        'duree',
        'description',
        'date_sortie',
        'fichier',
        'like',
        'id_album',
        'id_genre',
        'id_artiste',
    ];
}
