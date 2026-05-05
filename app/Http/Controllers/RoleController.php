<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'integer', 'in:1,2,3'],
        ]);

        $user->update([
            'role' => (int) $validated['role'],
        ]);

        return redirect()->route('users.index', ['search' => $request->input('search', '')])
            ->with('success', 'Role utilisateur mis a jour.');
    }
}
