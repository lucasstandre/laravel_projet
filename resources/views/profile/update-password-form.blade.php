<section>
    <header style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700; color: #ffc500; margin: 0;">
            {{ __('Modifier le Mot de Passe') }}
        </h2>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.7);">
            {{ __('Assurez-vous d\'utiliser un mot de passe long et aléatoire pour rester sécurisé.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="margin-top: 1.5rem; display: grid; gap: 1.5rem;">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;" autocomplete="current-password" />
            @error('current_password')
                <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;" autocomplete="new-password" />
            @error('password')
                <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Confirmez le mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;" autocomplete="new-password" />
            @error('password_confirmation')
                <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" style="padding: 0.75rem 1.5rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; font-size: 0.95rem;">
                {{ __('Sauvegarder') }}
            </button>

            @if (session('status') === 'password-updated')
                <p style="margin: 0; font-size: 0.9rem; color: #45b071;">
                    {{ __('Mot de passe mis à jour.') }}
                </p>
            @endif
        </div>
    </form>
</section>
