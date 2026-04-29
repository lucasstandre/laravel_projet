<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChansonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_chanson' => $this->id_chanson,
            'nom' => $this->nom,
            'duree' => $this->duree,
            'description' => $this->description,
            'date_sortie' => $this->date_sortie,
            'fichier' => $this->fichier,
            'like' => $this->like,
            'id_album' => $this->id_album,
            'id_genre' => $this->id_genre,
            'id_artiste' => $this->id_artiste
        ];
    }
}
