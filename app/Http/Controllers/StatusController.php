<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function status(?int $status = null): int
    {
        return in_array($status, [0, 1], true) ? $status : 0;
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'integer', 'in:0,1'],
        ]);

        $user->update([
            'status' => $this->status((int) $validated['status']),
        ]);

        return redirect()->route('users.index', ['search' => $request->input('search', '')])
            ->with('success', 'Status utilisateur mis a jour.');
    }
}
