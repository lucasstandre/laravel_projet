<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    protected $table = 'subscription_types';
    protected $fillable = ['name', 'label'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
