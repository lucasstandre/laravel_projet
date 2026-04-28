<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::orderBy('name_country')->get(); // Récupérer les pays triés par nom
        return view('auth.register', compact('countries')); // Passer les pays à la vue
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'integer', 'exists:countries,id_country'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'country' => (int) $request->country,
            'email' => $request->email,
            'status' => 0,
            'role' => 2,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
    public function show(Request $request)
    {
        $validation = Validator::make($request->all(), [
        'courriel' => 'required|email',
        'mot_de_passe' => 'required',
        'nom_token' => 'required'
    ], [
        'courriel.required' => 'Veuillez entrer le courriel de l\'utilisateur.',
        'courriel.email' => 'Le courriel de l\'utilisateur doit être valide.',
        'mot_de_passe.required' => 'Veuillez entrer le mot de passe de l\'utilisateur.',
        'nom_token.required' => 'Veuillez inscrire le nom souhaité pour le token.'
    ]);
        if ($validation->fails())
            return response()->json(['ERREUR' => $validation->errors()], 400);
        $contenuDecode = $validation->validated();
        $utilisateur = User::where('email', '=', $contenuDecode['courriel'])->first();
        if (($utilisateur === null) || !Hash::check($contenuDecode['mot_de_passe'], $utilisateur->password))
        return response()->json(['ERREUR' => 'Informations d\'authentification invalides'], 500);

        return response()->json(
            ['SUCCÈS' => $utilisateur->createToken($contenuDecode['nom_token'])->plainTextToken], 200
        );
    }

}
