<x-guest-layout>
    <div class="auth-head">
        <h1 class="auth-title">Connexion</h1>
        <p class="auth-subtitle">Entrez vos identifiants pour acceder a Sonora.</p>
    </div>

    <x-auth-session-status class="auth-session-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form-grid">
        @csrf

        <div class="auth-field-wrap">
            <label class="auth-label" for="email">username</label>
            <div class="auth-input-wrap">
                <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="auth-field-wrap">
            <label class="auth-label" for="password">Mot de passe</label>
            <div class="auth-input-wrap">
                <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="********">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="auth-cta">Se connecter</button>

        <div class="auth-footnote">
            <span>Pas encore de compte ?</span>
            <a class="auth-link" href="{{ route('register') }}">S'inscrire</a>
        </div>
    </form>
</x-guest-layout>
