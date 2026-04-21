@extends('layouts.main')

@section('title', 'Utilisateurs - Sonora')

@section('content')
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <a href="{{ route('home') }}" style="font-size: 2rem; font-weight: 800; color: #ffc500; font-style: italic; text-decoration: none;">Sonora</a>
        </div>

        @if (session('success'))
            <div style="margin-bottom: 1rem; padding: 0.8rem 1rem; border-radius: 8px; background: rgba(69, 176, 113, 0.2); border: 1px solid rgba(69, 176, 113, 0.5); color: #dff8e8;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabs/Filtres -->
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(126, 162, 211, 0.16); padding-bottom: 1rem; flex-wrap: wrap;">
            @if ($hasSearched)
                <a href="{{ route('users.index', ['search' => $search, 'filter' => 'playlist']) }}" style="padding: 0.5rem 1rem; border-radius: 9999px; background: rgba(126, 162, 211, {{ $filter == 'playlist' ? '0.3' : '0.18' }}); color: {{ $filter == 'playlist' ? '#f3f8ff' : 'rgb(196, 214, 241, 0.75)' }}; border: 1px solid rgba(126, 162, 211, 0.3); text-decoration: none; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 150ms ease;">Playlist</a>
                <a href="{{ route('users.index', ['search' => $search, 'filter' => 'artiste']) }}" style="padding: 0.5rem 1rem; border-radius: 9999px; background: rgba(126, 162, 211, {{ $filter == 'artiste' ? '0.3' : '0.18' }}); color: {{ $filter == 'artiste' ? '#f3f8ff' : 'rgb(196, 214, 241, 0.75)' }}; border: none; text-decoration: none; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 150ms ease;">Artiste</a>
                <a href="{{ route('users.index', ['search' => $search, 'filter' => 'album']) }}" style="padding: 0.5rem 1rem; border-radius: 9999px; background: rgba(126, 162, 211, {{ $filter == 'album' ? '0.3' : '0.18' }}); color: {{ $filter == 'album' ? '#f3f8ff' : 'rgb(196, 214, 241, 0.75)' }}; border: none; text-decoration: none; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 150ms ease;">Album</a>
                <a href="{{ route('users.index', ['search' => $search, 'filter' => 'user']) }}" style="padding: 0.5rem 1rem; border-radius: 9999px; background: rgba(126, 162, 211, {{ $filter == 'user' ? '0.3' : '0.18' }}); color: {{ $filter == 'user' ? '#f3f8ff' : 'rgb(196, 214, 241, 0.75)' }}; border: 1px solid rgba(126, 162, 211, 0.3); text-decoration: none; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 150ms ease;">User</a>
                <a href="{{ route('users.index', ['search' => $search, 'filter' => 'tracks']) }}" style="padding: 0.5rem 1rem; border-radius: 9999px; background: rgba(126, 162, 211, {{ $filter == 'tracks' ? '0.3' : '0.18' }}); color: {{ $filter == 'tracks' ? '#f3f8ff' : 'rgb(196, 214, 241, 0.75)' }}; border: none; text-decoration: none; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 150ms ease;">Tracks</a>
            @endif
        </div>

        <form method="GET" action="{{ route('users.index') }}" style="display: flex; gap: 0.5rem; margin-bottom: 2rem;">
            <input type="text" name="search" placeholder="Filtrer par nom..." value="{{ $search }}" style="flex: 1; padding: 0.75rem 1.5rem; border: 1px solid rgba(126, 162, 211, 0.16); border-radius: 9999px; background: rgba(28, 50, 84, 0.78); color: #f1f7ff; font-size: 0.9rem;">
            <button type="submit" style="padding: 0.75rem 1.5rem; border-radius: 9999px; background: #ffc500; color: #0b1528; border: none; font-weight: 800; cursor: pointer;">Filtrer</button>
            @if ($search)
                <a href="{{ route('users.index') }}" style="padding: 0.75rem 1.5rem; border-radius: 9999px; background: rgba(126, 162, 211, 0.18); color: #f1f7ff; border: 1px solid rgba(126, 162, 211, 0.3); text-decoration: none; font-weight: 600; cursor: pointer;">Réinitialiser</a>
            @endif
        </form>

        @if ($users->count() > 0)
            <p style="margin-bottom: 1rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.6);">


                Résultats pour "<strong style="color: #ffc500;">{{ $search }}</strong>" ({{ $users->total() }} utilisateur(s))
            </p>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
                <thead>
                    <tr style="background: rgba(28, 50, 84, 0.5); border-top: 1px solid rgba(126, 162, 211, 0.16); border-bottom: 1px solid rgba(126, 162, 211, 0.16);">
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Nom</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Pays</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Email</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Status</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Role</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Playlists</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: rgb(196, 214, 241, 0.75); font-size: 0.8rem; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr style="border-bottom: 1px solid rgba(126, 162, 211, 0.1); transition: background 150ms ease;">
                            <td style="padding: 0.75rem 1rem; color: #dbe7ff; font-size: 0.9rem;">{{ $user->name }}</td>
                            <td style="padding: 0.75rem 1rem; color: #dbe7ff; font-size: 0.9rem;">{{ $user->country ?? '-' }}</td>
                            <td style="padding: 0.75rem 1rem; color: #dbe7ff; font-size: 0.9rem;">{{ $user->email }}</td>
                            <td style="padding: 0.75rem 1rem; color: #dbe7ff; font-size: 0.9rem;">
                                @auth
                                    <form method="POST" action="{{ route('users.status.update', $user) }}" style="display: inline-flex; gap: 0.4rem; align-items: center;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="search" value="{{ $search }}">
                                        <select name="status" style="padding: 0.3rem 0.4rem; border-radius: 6px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.9); color: #f1f7ff;">
                                            <option value="0" {{ (int) $user->status === 0 ? 'selected' : '' }}>Public</option>
                                            <option value="1" {{ (int) $user->status === 1 ? 'selected' : '' }}>Prive</option>
                                        </select>
                                        <button type="submit" style="padding: 0.25rem 0.5rem; border: 1px solid rgba(126, 162, 211, 0.4); border-radius: 6px; background: transparent; color: #dbe7ff; cursor: pointer;">OK</button>
                                    </form>
                                @else
                                    {{ (int) $user->status === 1 ? 'Prive' : 'Public' }}
                                @endauth
                            </td>
                            <td style="padding: 0.75rem 1rem; color: #dbe7ff; font-size: 0.9rem;">
                                @auth
                                    <form method="POST" action="{{ route('users.role.update', $user) }}" style="display: inline-flex; gap: 0.4rem; align-items: center;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="search" value="{{ $search }}">
                                        <select name="role" style="padding: 0.3rem 0.4rem; border-radius: 6px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.9); color: #f1f7ff;">
                                            <option value="1" {{ (int) $user->role === 1 ? 'selected' : '' }}>Admin</option>
                                            <option value="2" {{ (int) $user->role === 2 ? 'selected' : '' }}>Artiste</option>
                                            <option value="3" {{ (int) $user->role === 3 ? 'selected' : '' }}>User</option>
                                        </select>
                                        <button type="submit" style="padding: 0.25rem 0.5rem; border: 1px solid rgba(126, 162, 211, 0.4); border-radius: 6px; background: transparent; color: #dbe7ff; cursor: pointer;">OK</button>
                                    </form>
                                @else
                                    @if ((int) $user->role === 1)
                                        Admin
                                    @elseif ((int) $user->role === 2)
                                        Artiste
                                    @else
                                        User
                                    @endif
                                @endauth
                            </td>
                            <td style="padding: 0.75rem 1rem; color: #dbe7ff; font-size: 0.9rem;">{{ $user->playlists_count }}</td>
                            <td style="padding: 0.75rem 1rem;">
                                <a href="{{ route('users.show', $user) }}" style="color: rgb(196, 214, 241, 0.75); text-decoration: none; font-size: 0.8rem;">Voir</a>
                                @auth
                                    <a href="{{ route('users.edit', $user) }}" style="margin-left: 0.7rem; color: #ffc500; text-decoration: none; font-size: 0.8rem;">Modifier</a>
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" style="display: inline; margin-left: 0.7rem;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Supprimer cet utilisateur ?')" style="background: transparent; border: none; padding: 0; color: #ff7a7a; font-size: 0.8rem; cursor: pointer;">Supprimer</button>
                                    </form>
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display: flex; justify-content: center; gap: 0.5rem;">
                {{ $users->links() }}
            </div>
        @elseif ($hasSearched)
            <p style="text-align: center; color: rgb(196, 214, 241, 0.6); padding: 2rem;">Aucun utilisateur trouvé pour "<strong style="color: #ffc500;">{{ $search }}</strong>".</p>
        @else
            <p style="text-align: center; color: rgb(196, 214, 241, 0.6); padding: 3rem; font-size: 1.1rem;">
                Tapez le nom d'un utilisateur pour commencer...
            </p>
        @endif
    </div>
</div>
