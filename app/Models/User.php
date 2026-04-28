<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'id_country', 'country', 'email', 'status', 'role', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'status' => 'integer',
            'role' => 'integer',
            'password' => 'hashed',
        ];
    }
    public function playlists(): HasMany
    {
    // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
    return $this->HasMany(Playlist::class, 'id_creator');
    }
    public function ecoutes(): HasMany
    {
    // Il faut préciser la classe (le modèle) avec laquelle la relation s’établit.
    return $this->hasMany(Ecoute::class, 'id_utilisateur');
    }
    // quand ca cree un user ca cree aussi la playlist de like et un abonnement par défaut
    // plus facil a utiliser que boot !!!
    protected static function booted(): void
    {
        static::created(function (User $user) {
            // Créer la playlist "Liked"
            Playlist::create([
                'id_creator' => $user->id,
                'playlist' => 'Liked',
                'description' => 'Mes chansons aimées',
                'link' => '',
                'original' => true,
            ]);

            // Créer un abonnement par défaut (de base)
            Subscription::create([
                'user_id' => $user->id,
                'subscription_type_id' => 1,
                'type' => 'de base',
            ]);
        });
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'id_country', 'id_country');
    }

    /**
     * Get the country name - handles both legacy 'country' field and relation
     */
    public function getCountryNameAttribute(): ?string
    {
        // If the relationship is loaded and has a value
        if ($this->relationLoaded('country') && $this->country) {
            return $this->country->name_country;
        }

        // If id_country is set, load the country
        if ($this->id_country) {
            $country = Country::find($this->id_country);
            return $country ? $country->name_country : null;
        }

        // Fallback to legacy 'country' column if it exists
        if (isset($this->attributes['country']) && $this->attributes['country']) {
            return $this->attributes['country'];
        }

        return null;
    }

    public function mediaSocials(): HasMany
    {
        return $this->hasMany(MediaSocial::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }


}

