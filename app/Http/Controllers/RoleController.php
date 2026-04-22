<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function role(?int $role = null): int
    {
        // 3 est le role par defaut (utilisateur) 1 est admin et 2 est artiste
        return in_array($role, [1, 2, 3], true) ? $role : 3;
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'integer', 'in:1,2,3'],
        ]);

        $user->update([
            'role' => $this->role((int) $validated['role']),
        ]);

        return redirect()->route('users.index', ['search' => $request->input('search', '')])
            ->with('success', 'Role utilisateur mis a jour.');
    }
}
