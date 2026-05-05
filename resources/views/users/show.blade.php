<x-app-layout>
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <a href="{{ route('users.index') }}" style="display: inline-block; margin-bottom: 1.5rem; color: #ffc500; font-weight: 700; text-decoration: none;">← Retour</a>

        <div style="background: rgba(28, 50, 84, 0.7); border: 1px solid rgba(126, 162, 211, 0.16); padding: 1.5rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);">
            <h1 style="margin: 0 0 0.5rem 0; font-size: 1.9rem; font-weight: 800; color: #ffffff;">{{ $user->name }}</h1>
            <p style="margin: 0.35rem 0; color: rgb(196, 214, 241, 0.82);"><strong style="color: #ffc500;">Pays:</strong> {{ $user->country->name_country ?? '-' }}</p>
            <p style="margin: 0.35rem 0; color: rgb(196, 214, 241, 0.82);"><strong style="color: #ffc500;">Email:</strong> {{ $user->email }}</p>
            <p style="margin: 0.35rem 0; color: rgb(196, 214, 241, 0.82);"><strong style="color: #ffc500;">Playlists:</strong> {{ $user->playlists->count() }}</p>
        </div>

        @if ($playlists->count() > 0)
            <h2 style="margin: 0 0 1rem 0; font-size: 1.2rem; font-weight: 700; color: #ffffff;">Playlists</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                @foreach ($playlists as $playlist)
                    <div style="background: rgba(28, 50, 84, 0.7); padding: 1rem; border-radius: 14px; border: 1px solid rgba(126, 162, 211, 0.16); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.16);">
                        <h3 style="margin: 0 0 0.5rem 0; color: #ffffff; font-size: 1.05rem;">{{ $playlist->playlist ?? 'Sans titre' }}</h3>
                        <a href="{{ route('playlist', $playlist->id_playlist) }}" style="display: inline-block; margin-top: 0.75rem; color: #ffc500; font-weight: 600; text-decoration: none;">Voir musiques</a>
                    </div>
                @endforeach
            </div>

            @if ($playlists->hasPages())
                <div style="display: flex; justify-content: center; gap: 0.5rem;">
                    {{ $playlists->links() }}
                </div>
            @endif
        @else
            <p style="text-align: center; color: rgb(196, 214, 241, 0.65); padding: 2rem;">{{ $user->name }} n'a pas encore créé de playlist.</p>
        @endif
    </div>
</div>

</x-app-layout>
