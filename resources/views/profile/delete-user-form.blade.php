<section>
    <header style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700; color: #ff7a7a; margin: 0;">
            {{ __('Supprimer le Compte') }}
        </h2>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.7);">
            {{ __('Supprimez votre compte de manière permanente. Cette action ne peut pas être annulée.') }}
        </p>
    </header>

    <button popovertarget="confirm-user-deletion" style="padding: 0.75rem 1.5rem; border: none; border-radius: 8px; background: #ff7a7a; color: #fff; font-weight: 700; cursor: pointer; font-size: 0.95rem; margin-top: 1rem;">
        {{ __('Supprimer le Compte') }}
    </button>

    <div id="confirm-user-deletion" popover="auto" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); border: 1px solid rgba(126, 162, 211, 0.3); border-radius: 12px; padding: 2rem; max-width: 500px; color: #dbe7ff; z-index: 1000;">
        <h2 style="font-size: 1.3rem; font-weight: 700; color: #ff7a7a; margin: 0 0 1rem 0;">
            {{ __('Êtes-vous sûr ?') }}
        </h2>

        <p style="margin: 0 0 1.5rem 0; font-size: 0.95rem; color: rgb(196, 214, 241, 0.8);">
            {{ __('Cette action supprimera définitivement votre compte et toutes vos données. Veuillez entrer votre mot de passe pour confirmer.') }}
        </p>

        <form method="post" action="{{ route('profile.destroy') }}" style="display: grid; gap: 1rem;">
            @csrf
            @method('delete')

            <div>
                <label for="password" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Mot de passe</label>
                <input id="password" name="password" type="password" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;" placeholder="Entrez votre mot de passe" />
                @error('userDeletion.password')
                    <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" popovertarget="confirm-user-deletion" popovertargetaction="hide" style="padding: 0.75rem 1.5rem; border: 1px solid rgba(126, 162, 211, 0.3); border-radius: 8px; background: transparent; color: #dbe7ff; cursor: pointer; font-weight: 600;">
                    {{ __('Annuler') }}
                </button>

                <button type="submit" style="padding: 0.75rem 1.5rem; border: none; border-radius: 8px; background: #ff7a7a; color: #fff; font-weight: 700; cursor: pointer;">
                    {{ __('Supprimer le Compte') }}
                </button>
            </div>
        </form>
    </div>
</section>
