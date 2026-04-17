<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playlist extends Model
{
    use HasFactory;
    protected $table = 'playlists';
    protected $primaryKey = 'id_playlist';
    public $timestamps = true;

}
