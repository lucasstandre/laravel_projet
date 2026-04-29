<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Chanson;

class Album extends Model
{
    use HasFactory;
    protected $table = 'albums';
    protected $primaryKey = 'id_album';
    public $timestamps = false;
    protected $fillable = ['nom', 'photo'];

    public function chansons(): HasMany
    {
        return $this->hasMany(Chanson::class, 'id_album', 'id_album');
    }
}
