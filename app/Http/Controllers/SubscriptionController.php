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
            'type' => ['required', 'in:de base,premium'],
        ]);

        // Créer ou mettre à jour l'abonnement
        Subscription::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['type' => $validated['type']]
        );

        return Redirect::route('profile.edit')->with('status', 'subscription-created');
    }

    /**
     * Update user's subscription
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:de base,premium'],
        ]);

        $subscription = $request->user()->subscription;

        if ($subscription) {
            $subscription->update($validated);
        } else {
            Subscription::create([
                'user_id' => $request->user()->id,
                'type' => $validated['type'],
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'subscription-updated');
    }

    /**
     * Delete subscription (reset to 'de base')
     */
    public function destroy(Request $request): RedirectResponse
    {
        $subscription = $request->user()->subscription;

        if ($subscription && $subscription->type === 'premium') {
            $subscription->update(['type' => 'de base']);
        }

        return Redirect::route('profile.edit')->with('status', 'subscription-deleted');
    }
}
