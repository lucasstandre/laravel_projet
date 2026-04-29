@extends('layouts.main')

@section('title', 'Albums')

@section('content')
<style>
    .albums-page { background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff; }
    .albums-container { max-width: 900px; margin: 0 auto; }
    .albums-filters { display: flex; gap: 0.75rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .albums-filters input, .albums-filters select { padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; }
    .albums-filters input::placeholder { color: rgba(219, 231, 255, 0.4); }
    .btn-filter { padding: 0.5rem 1.5rem; border-radius: 6px; border: none; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; }
    .album-card { display: flex; gap: 1rem; margin-bottom: 1rem; padding: 1rem; background: rgba(28, 50, 84, 0.7); border-radius: 8px; text-decoration: none; color: inherit; }
    .album-card:hover { background: rgba(28, 50, 84, 0.9); }
    .album-card img { width: 80px; height: 80px; border-radius: 4px; object-fit: cover; }
    .album-card p { margin: 0.2rem 0; }
</style>

<div class="albums-page">
    <div class="albums-container">

        <form action="/albums" method="GET" class="albums-filters">
            <input type="text" name="search" placeholder="Trouver un album..." value="{{ request('search') }}">
            <select name="genre">
                <option value="">-- Genre --</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id_genre }}" {{ request('genre') == $genre->id_genre ? 'selected' : '' }}>
                        {{ $genre->genre }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">Filtrer</button>
        </form>

        <h1>Albums</h1>

        @foreach($albums as $album)
        <a href="{{ route('albums.edit', $album) }}" class="album-card">
            <img src="/images/{{ basename($album->photo) }}" alt="{{ $album->nom }}">
            <div>
                <p style="font-weight: bold;">{{ $album->nom }}</p>
                <p>Genre : {{ $album->chansons->first()?->genre->genre ?? 'N/A' }}</p>
                <p>Artiste : {{ $album->chansons->first()?->user->name ?? 'N/A' }}</p>
                <p>Tracks : {{ $album->chansons->count() }}</p>
            </div>
        </a>
        @endforeach

    </div>
</div>
@endsection
