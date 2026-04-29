<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'status' => $this->status,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'country' => [
                'id' => $this->country?->id_country,
                'name' => $this->country?->name_country,
            ],
            'subscription' => [
                'id' => $this->subscription?->id,
                'type' => $this->subscription?->type,
                'subscription_type_id' => $this->subscription?->subscription_type_id,
            ],
            'media_socials' => $this->mediaSocials->map(function ($media) {
                return [
                    'id' => $media->id,
                    'nom' => $media->nom,
                    'url' => $media->url,
                ];
            }),
        ];
    }
}
