<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    /**
     * Get all countries for dropdown/list
     */
    public function index()
    {
        return Country::all();
    }

    /**
     * Store a new country
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:countries,nom'],
            'code' => ['nullable', 'string', 'max:10'],
        ]);

        Country::create($validated);

        return Redirect::route('profile.edit')->with('status', 'country-added');
    }

    /**
     * Update user's country
     */
    public function updateUserCountry(Request $request)
    {
        $validated = $request->validate([
            'id_country' => ['required', 'exists:countries,id_country'],
        ]);

        $request->user()->update($validated);

        return Redirect::route('profile.edit')->with('status', 'country-updated');
    }

    /**
     * Delete (set to N/A) user's country
     */
    public function deleteUserCountry(Request $request)
    {
        $request->user()->update(['id_country' => null]);

        return Redirect::route('profile.edit')->with('status', 'country-deleted');
    }

    /**
     * Destroy a country (admin only)
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return Redirect::route('profile.edit')->with('status', 'country-destroyed');
    }
}
