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

#[Fillable(['name', 'id_country', 'email', 'status', 'role', 'password'])]
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
    // quand ca cree un user ca cree aussi la playlist de like
    // plus facil a utiliser que boot !!!
    protected static function booted(): void
    {
        static::created(function (User $user) {
            Playlist::create([
                'id_creator' => $user->id,
                'playlist' => 'Liked',
                'description' => 'Mes chansons aimées',
                'link' => '',
                'original' => true,
            ]);
        });

    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'id_country', 'id_country');
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

