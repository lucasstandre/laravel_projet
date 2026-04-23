<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ecoute extends Model
{
    use HasFactory;
    protected $table = 'ecoutes';
    protected $primaryKey = 'id_ecoute';
    public $timestamps = false;
    protected $duree = 'duree';
    protected $fillable = ['id_ecoute', 'duree', 'timestamp', 'id_utilisateur', 'id_chanson'];

    public function user(): BelongsTo
    {
    // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
    return $this->belongsTo(User::class, 'id_utilisateur'); // id de la personne qui ecoute
    }
    public function chanson(): BelongsTo
    {
    // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
    return $this->belongsTo(Chanson::class, 'id_chanson'); // id de la chanson
    }




}
