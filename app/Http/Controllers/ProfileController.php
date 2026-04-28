<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\MediaSocial;
use App\Models\Country;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load('subscription.subscriptionType');
        $mediaSocials = $user->mediaSocials;
        $countries = Country::all();

        // Si pas de subscription, en créer une avec les deux colonnes (type ET subscription_type_id)
        if (!$user->subscription) {
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'subscription_type_id' => 1,
                'type' => 'de base'  // Inclure 'type' aussi
            ]);
        } else {
            $subscription = $user->subscription;
        }

        return view('profile.edit', [
            'user' => $user,
            'mediaSocials' => $mediaSocials,
            'countries' => $countries,
            'subscription' => $subscription,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Store a new media social for the user.
     */
    public function storeMediaSocial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'icone' => ['nullable', 'string', 'max:50'],
        ]);

        $request->user()->mediaSocials()->create($validated);

        return Redirect::route('profile.edit')->with('status', 'media-social-added');
    }

    /**
     * Update a media social.
     */
    public function updateMediaSocial(Request $request, MediaSocial $mediaSocial): RedirectResponse
    {
        // Vérifier que l'utilisateur possède ce média social
        if ($mediaSocial->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'icone' => ['nullable', 'string', 'max:50'],
        ]);

        $mediaSocial->update($validated);

        return Redirect::route('profile.edit')->with('status', 'media-social-updated');
    }

    /**
     * Delete a media social.
     */
    public function destroyMediaSocial(Request $request, MediaSocial $mediaSocial): RedirectResponse
    {
        // Vérifier que l'utilisateur possède ce média social
        if ($mediaSocial->user_id !== $request->user()->id) {
            abort(403);
        }

        $mediaSocial->delete();

        return Redirect::route('profile.edit')->with('status', 'media-social-deleted');
    }
}
