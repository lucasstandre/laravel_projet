<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display list of users with search
     */
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $pays = $request->input('pays', '');
        $filter = $request->input('filter', 'user');

        $query = User::query()->with('country')->withCount('playlists');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter by country
        if ($pays) {
            $query->where('id_country', $pays);
        }

        // Toujours paginer les utilisateurs pour afficher la navigation (pagination)
        // Si vous voulez limiter la charge, ajoutez des filtres ou une condition ici.
        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        // Get all countries for the filter
        $countries = Country::orderBy('name_country')->get();

        return view('users.index', [
            'users' => $users,
            'search' => $search,
            'pays' => $pays,
            'filter' => $filter,
            'countries' => $countries,
            'hasSearched' => !empty($search) || !empty($pays)
        ]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_country' => ['nullable', 'integer', 'exists:countries,id_country'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);

        User::create([
            'name' => $validated['name'],
            'id_country' => $validated['id_country'] ?? null,
            'email' => $validated['email'],
            'status' => 0,
            'role' => 2,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect(route('dashboard', absolute: false));
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_country' => ['nullable', 'integer', 'exists:countries,id_country'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'id_country' => $validated['id_country'] ?? null,
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur modifie.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprime.');
    }

    /**
     * Display user profile with their playlists
     */
    public function show(User $user): View
    {
        $playlists = $user->playlists()->paginate(10);

        return view('users.show', [
            'user' => $user,
            'playlists' => $playlists
        ]);
    }
}
