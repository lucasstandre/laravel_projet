<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{
    /**
     * Store a subscription for the user
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subscription_type_id' => ['required', 'exists:subscription_types,id'],
        ]);

        // Map subscription_type_id to type
        $typeMap = [1 => 'de base', 2 => 'premium'];
        $type = $typeMap[$validated['subscription_type_id']] ?? 'de base';

        // Créer ou mettre à jour l'abonnement
        Subscription::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                ...$validated,
                'type' => $type
            ]
        );

        return Redirect::route('profile.edit')->with('status', 'subscription-created');
    }

    /**
     * Update user's subscription
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subscription_type_id' => ['required', 'exists:subscription_types,id'],
        ]);

        $subscription = $request->user()->subscription;

        // Map subscription_type_id to type
        $typeMap = [1 => 'de base', 2 => 'premium'];
        $type = $typeMap[$validated['subscription_type_id']] ?? 'de base';

        if ($subscription) {
            $subscription->update([
                ...$validated,
                'type' => $type
            ]);
            $subscription->refresh();
        } else {
            Subscription::create([
                'user_id' => $request->user()->id,
                ...$validated,
                'type' => $type
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'subscription-updated');
    }

    /**
     * Delete subscription (reset to 'de base' - ID 1)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $subscription = $request->user()->subscription;

        if ($subscription) {
            // Rétrograder à l'abonnement de base (ID 1, type 'de base')
            $subscription->update([
                'subscription_type_id' => 1,
                'type' => 'de base'
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'subscription-deleted');
    }
}

