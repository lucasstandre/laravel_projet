<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ApiAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['sometimes', 'required_without_all:courriel', 'email'],
            'password' => ['sometimes', 'required_without_all:mot_de_passe', 'string'],
            'device_name' => ['sometimes', 'required_without_all:nom_token', 'string', 'max:255'],
            'courriel' => ['sometimes', 'required_without_all:email', 'email'],
            'mot_de_passe' => ['sometimes', 'required_without_all:password', 'string'],
            'nom_token' => ['sometimes', 'required_without_all:device_name', 'string', 'max:255'],
        ]);

        $email = $data['email'] ?? $data['courriel'];
        $password = $data['password'] ?? $data['mot_de_passe'];
        $deviceName = $data['device_name'] ?? $data['nom_token'] ?? 'api-token';

        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Informations d\'authentification invalides.',
            ], 422);
        }

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $user->createToken($deviceName)->plainTextToken,
            'user' => new UserResource($user->load('country', 'subscription', 'mediaSocials')),
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_country' => ['required', 'integer', 'exists:countries,id_country'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'id_country' => (int) $validated['id_country'],
            'email' => $validated['email'],
            'status' => 0,
            'role' => 2,
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $user->createToken($request->input('device_name', 'api-token'))->plainTextToken,
            'user' => new UserResource($user->load('country', 'subscription', 'mediaSocials')),
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }
}
