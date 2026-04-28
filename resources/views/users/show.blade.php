<x-app-layout>
<div style="max-width: 1000px; margin: 0 auto; padding: 2rem;">
    <a href="{{ route('users.index') }}" style="color: #007bff; text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Retour</a>

    <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #e0e0e0;">
        <h1 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">{{ $user->name }}</h1>
        <p style="margin: 0.25rem 0; color: #666;"><strong>Pays:</strong> {{ $user->country->name_country ?? '-' }}</p>
        <p style="margin: 0.25rem 0; color: #666;"><strong>Email:</strong> {{ $user->email }}</p>
        <p style="margin: 0.25rem 0; color: #666;"><strong>Playlists:</strong> {{ $user->playlists->count() }}</p>
    </div>

    @if ($playlists->count() > 0)
        <h2 style="margin: 2rem 0 1rem 0; font-size: 1.2rem;">Playlists</h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            @foreach ($playlists as $playlist)
                <div style="background: #f9f9f9; padding: 1rem; border-radius: 4px; border: 1px solid #e0e0e0;">
                    <h3 style="margin: 0 0 0.5rem 0;">{{ $playlist->name ?? 'Sans titre' }}</h3>
                    <p style="margin: 0.25rem 0; font-size: 0.9rem; color: #666;">ID: #{{ $playlist->id_playlist }}</p>
                    {{--{{<p style="margin: 0.25rem 0; font-size: 0.9rem; color: #666;">Créée: {{ $playlist->created_at->format('d/m/Y') }}</p>}}--}}
                    <a href="{{ route('playlist', $playlist->id_playlist) }}" style="display: inline-block; margin-top: 0.75rem; color: #007bff; text-decoration: none;">Voir musiques</a>
                </div>
            @endforeach
        </div>

        @if ($playlists->hasPages())
            <div style="display: flex; justify-content: center; gap: 0.5rem;">
                {{ $playlists->links() }}
            </div>
        @endif
    @else
        <p style="text-align: center; color: #666; padding: 2rem;">{{ $user->name }} n'a pas encore créé de playlist.</p>
    @endif
</div>

</x-app-layout>
