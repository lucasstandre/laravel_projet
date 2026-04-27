<x-guest-layout>
    <div class="auth-head">
        <h1 class="auth-title">S'inscrire</h1>
        <p class="auth-subtitle">En vous inscrivant vous accederez aux fonctionnalités Sonora.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form-grid">
        @csrf

        <div class="auth-field-wrap">
            <label class="auth-label" for="name">Username</label>
            <div class="auth-input-wrap">
                <input id="name" class="auth-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="username">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="auth-field-wrap">
            <label class="auth-label" for="password">Mot de passe</label>
            <div class="auth-input-wrap">
                <input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="********">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="auth-field-wrap">
            <label class="auth-label" for="password_confirmation">Confirmation mot de passe</label>
            <div class="auth-input-wrap">
                <input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="auth-secondary-grid">
            <div class="auth-field-wrap">
                <label class="auth-label" for="email">Courriel</label>
                <div class="auth-input-wrap">
                    <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nom@domaine.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="auth-field-wrap">
                <label class="auth-label" for="country">Pays</label>
                <div class="auth-input-wrap">
                    <select id="country" class="auth-input" name="country" required>
                        <option value="">Sélectionnez un pays</option>
                        {{-- Boucle foreach pour allez chercher les pays dans la base de données --}}
                        @foreach($countries as $country)
                            <option value="{{ $country->id_country }}" {{ old('country') == $country->id_country ? 'selected' : '' }}>
                                {{ $country->name_country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>
        </div>



        <button type="submit" class="auth-cta">S'inscrire</button>

        <div class="auth-footnote">
            <span>Déja un compte ?</span>
            <a class="auth-link" href="{{ route('login') }}">Connexion</a>
        </div>
    </form>
</x-guest-layout>
