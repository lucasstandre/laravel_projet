<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $filter = $request->input('filter', 'user');

        $query = User::query()->withCount('playlists');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Si search est vide, on ne fait pas la requete et on retourne une collection vide pour éviter de charger tous les utilisateurs
        $users = $search
            ? $query->orderBy('name')->paginate(10)->withQueryString()
            : collect();

        return view('users.index', [
            'users' => $users,
            'search' => $search,
            'filter' => $filter,
            'hasSearched' => !empty($search)
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
            'country' => ['nullable', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'country' => $validated['country'] ?? null,
            'email' => $validated['email'],
            'status' => 0,
            'role' => 3,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur cree.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'country' => $validated['country'] ?? null,
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
