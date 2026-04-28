<section>
    <header style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700; color: #ffc500; margin: 0;">
            {{ __('Informations Personnelles') }}
        </h2>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.7);">
            {{ __('Mettez à jour vos informations de profil.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="margin-top: 1.5rem; display: grid; gap: 1.5rem;">
        @csrf
        @method('patch')

        <div>
            <label for="name" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Nom</label>
            <input id="name" name="name" type="text" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Email</label>
            <input id="email" name="email" type="email" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 1rem; padding: 1rem; background: rgba(255, 122, 122, 0.1); border: 1px solid rgba(255, 122, 122, 0.3); border-radius: 6px;">
                    <p style="margin: 0; font-size: 0.9rem; color: #ff7a7a;">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}
                        <button form="send-verification" type="button" style="background: transparent; border: none; color: #ffc500; cursor: pointer; text-decoration: underline; padding: 0;">
                            {{ __('Cliquez ici pour renvoyer le lien de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: #45b071;">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" style="padding: 0.75rem 1.5rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; font-size: 0.95rem;">
                {{ __('Sauvegarder') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p style="margin: 0; font-size: 0.9rem; color: #45b071;">
                    {{ __('Profil mis à jour.') }}
                </p>
            @endif
        </div>
    </form>
</section>
