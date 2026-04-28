<section style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; border-radius: 8px; padding: 2rem;">
    <header style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #ffc500; margin: 0;">
            {{ __('Abonnement') }}
        </h2>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.7); margin-bottom: 0;">
            {{ __('Gérez votre plan d\'abonnement.') }}
        </p>
    </header>

    <div style="margin-top: 1.5rem;">
        <!-- Abonnement actuel -->
        <div style="margin-bottom: 2rem; padding: 1.5rem; background: rgba(28, 50, 84, 0.5); border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.2);">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #ffc500; margin: 0 0 1rem 0;">Abonnement actuel</h3>

            @if ($subscription)
                <div style="padding: 1rem; background: rgba(28, 50, 84, 0.3); border-radius: 6px; border-left: 3px solid #ffc500; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-size: 1rem; color: #dbe7ff; font-weight: 600;">
                            {{ ucfirst($subscription->type) }}
                            @if ($subscription->type === 'premium')
                                <span style="margin-left: 0.5rem; color: #ffc500; font-weight: 700;">⭐</span>
                            @endif
                        </p>
                    </div>
                    @if ($subscription->type === 'premium')
                        <form action="{{ route('profile.subscription.destroy') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Revenir à l\'abonnement de base ?')"
                                style="padding: 0.5rem 1rem; font-size: 0.85rem; background: #ff7a7a; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                Rétrograder
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <p style="text-align: center; color: rgb(196, 214, 241, 0.6); padding: 1.5rem; font-style: italic;">Aucun abonnement sélectionné</p>
            @endif
        </div>

        <!-- Changer l'abonnement -->
        <div style="margin-bottom: 2rem; padding: 1.5rem; background: rgba(28, 50, 84, 0.5); border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.2);">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #ffc500; margin: 0 0 1rem 0;">Changer d'abonnement</h3>

            <!-- Plans disponibles -->
            <div style="display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); margin-bottom: 1.5rem;">
                <!-- Plan de base -->
                <div style="padding: 1.5rem; background: rgba(28, 50, 84, 0.3); border: 2px solid rgba(126, 162, 211, 0.3); border-radius: 8px; {{ $subscription && $subscription->type === 'de base' ? 'border-color: #ffc500; background: rgba(255, 197, 0, 0.1);' : '' }}">
                    <h4 style="margin: 0 0 0.5rem 0; color: #dbe7ff; font-weight: 700;">De Base</h4>
                    <p style="margin: 0; color: rgb(196, 214, 241, 0.7); font-size: 0.9rem;">Accès gratuit et illimité</p>
                    @if (!$subscription || $subscription->type !== 'de base')
                        <form action="{{ route('profile.subscription.update') }}" method="POST" style="margin-top: 1rem;">
                            @csrf
                            <input type="hidden" name="type" value="de base">
                            <button type="submit" style="width: 100%; padding: 0.75rem; border: none; border-radius: 6px; background: #dbe7ff; color: #0b1528; font-weight: 600; cursor: pointer;">
                                Choisir
                            </button>
                        </form>
                    @else
                        <div style="margin-top: 1rem; padding: 0.75rem; background: #45b071; border-radius: 6px; text-align: center; color: white; font-weight: 600;">
                            Actuel
                        </div>
                    @endif
                </div>

                <!-- Plan premium -->
                <div style="padding: 1.5rem; background: rgba(28, 50, 84, 0.3); border: 2px solid rgba(255, 197, 0, 0.5); border-radius: 8px; {{ $subscription && $subscription->type === 'premium' ? 'border-color: #ffc500; background: rgba(255, 197, 0, 0.1);' : '' }}">
                    <h4 style="margin: 0 0 0.5rem 0; color: #ffc500; font-weight: 700;">⭐ Premium</h4>
                    <p style="margin: 0; color: rgb(196, 214, 241, 0.7); font-size: 0.9rem;">Accès premium avec avantages exclusifs</p>
                    @if (!$subscription || $subscription->type !== 'premium')
                        <form action="{{ route('profile.subscription.update') }}" method="POST" style="margin-top: 1rem;">
                            @csrf
                            <input type="hidden" name="type" value="premium">
                            <button type="submit" style="width: 100%; padding: 0.75rem; border: none; border-radius: 6px; background: #ffc500; color: #0b1528; font-weight: 600; cursor: pointer;">
                                Passer à Premium
                            </button>
                        </form>
                    @else
                        <div style="margin-top: 1rem; padding: 0.75rem; background: #45b071; border-radius: 6px; text-align: center; color: white; font-weight: 600;">
                            Actuel
                        </div>
                    @endif
                </div>
            </div>

            @if (session('status') === 'subscription-updated' || session('status') === 'subscription-created')
                <p style="margin: 0; font-size: 0.9rem; color: #45b071;">
                    {{ __('Abonnement mis à jour.') }}
                </p>
            @elseif (session('status') === 'subscription-deleted')
                <p style="margin: 0; font-size: 0.9rem; color: #45b071;">
                    {{ __('Abonnement rétrogradé.') }}
                </p>
            @endif
        </div>
    </div>
</section>
