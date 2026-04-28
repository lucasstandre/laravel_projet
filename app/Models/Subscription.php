<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'type', 'subscription_type_id'];

    protected static function boot()
    {
        parent::boot();

        // Synchroniser la colonne 'type' avec 'subscription_type_id' après la sauvegarde
        static::saved(function ($subscription) {
            // Si subscription_type_id a changé, mettre à jour 'type' aussi
            if ($subscription->subscription_type_id) {
                $typeMap = [
                    1 => 'de base',
                    2 => 'premium'
                ];
                $newType = $typeMap[$subscription->subscription_type_id] ?? null;
                if ($newType && $subscription->type !== $newType) {
                    // Mettre à jour directement dans la BD sans déclencher les hooks
                    \Illuminate\Support\Facades\DB::table('subscriptions')
                        ->where('id', $subscription->id)
                        ->update(['type' => $newType]);
                    // Mettre à jour l'instance
                    $subscription->type = $newType;
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class);
    }
}
