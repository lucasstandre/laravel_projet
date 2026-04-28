<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #ffc500; font-style: italic;">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; min-height: 100vh; padding: 2rem;">
        <div style="max-width: 900px; margin: 0 auto;">
            <!-- Informations de profil -->
            <div style="margin-bottom: 2rem; padding: 2rem; background: rgba(28, 50, 84, 0.3); border: 1px solid rgba(126, 162, 211, 0.2); border-radius: 12px;">
                    <div>
                    @include('profile.update-profile-information-form')
                </div>
            </div>

            <!-- Mot de passe -->
            <div style="margin-bottom: 2rem; padding: 2rem; background: rgba(28, 50, 84, 0.3); border: 1px solid rgba(126, 162, 211, 0.2); border-radius: 12px;">
                    <div>
                    @include('profile.update-password-form')
                </div>
            </div>

            <!-- Médias sociaux -->
            <div style="margin-bottom: 2rem; padding: 2rem; background: rgba(28, 50, 84, 0.3); border: 1px solid rgba(126, 162, 211, 0.2); border-radius: 12px;">
                    <div>
                    @include('profile.manage-media-socials-form')
                </div>
            </div>

            <!-- Pays -->
            <div style="margin-bottom: 2rem; padding: 2rem; background: rgba(28, 50, 84, 0.3); border: 1px solid rgba(126, 162, 211, 0.2); border-radius: 12px;">
                    <div>
                    @include('profile.manage-country-form')
                </div>
            </div>

            <!-- Abonnement -->
            <div style="margin-bottom: 2rem; padding: 2rem; background: rgba(28, 50, 84, 0.3); border: 1px solid rgba(126, 162, 211, 0.2); border-radius: 12px;">
                    <div>
                    @include('profile.manage-subscription-form')
                </div>
            </div>

            <!-- Supprimer le compte -->
            <div style="margin-bottom: 2rem; padding: 2rem; background: rgba(28, 50, 84, 0.3); border: 1px solid rgba(126, 162, 211, 0.2); border-radius: 12px;">
                    <div>
                    @include('profile.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
