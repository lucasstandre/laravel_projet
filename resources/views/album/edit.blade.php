@extends('layouts.main')

@section('title', 'Modifier ' . $album->nom)

@section('content')
<style>
    .album-edit-page { background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff; }
    .album-edit-container { max-width: 700px; margin: 0 auto; }
    .album-edit-header { display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem; }
    .album-edit-header img { width: 100px; height: 100px; border-radius: 8px; object-fit: cover; }
    .album-edit-input { padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 1.5rem; width: 100%; }
    .album-edit-label { margin: 0.5rem 0 0.25rem; display: block; color: #dbe7ff; }
    .album-edit-select { width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; margin-bottom: 1rem; }
    .album-edit-actions { display: flex; justify-content: space-between; margin-top: 1.5rem; }
    .btn-save { padding: 0.7rem 2rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; }
    .btn-delete { padding: 0.7rem 2rem; border: none; border-radius: 8px; background: rgba(255, 80, 80, 0.2); border: 1px solid rgba(255, 80, 80, 0.5); color: #ffaaaa; font-weight: 700; cursor: pointer; }
    .album-tracks { background: rgba(10, 30, 60, 0.8); border-radius: 12px; padding: 1rem; margin-top: 1.5rem; }
    .album-track-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid rgba(126, 162, 211, 0.2); }
    .album-track-row:last-child { border-bottom: none; }
    .btn-track-delete { background: none; border: none; cursor: pointer; color: red; font-size: 1rem; }
</style>

<div class="album-edit-page">
    <div class="album-edit-container">

        {{-- Formulaire principal --}}
        {{-- Enctype pour permettre les photos --}}
        <form method="POST" action="{{ route('albums.update', $album) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="album-edit-header">
                <img src="/images/{{ basename($album->photo) }}" alt="{{ $album->nom }}">
                <input type="text" name="nom" value="{{ $album->nom }}" class="album-edit-input">
            </div>
            <label class="btn-filter" style="cursor: pointer;">
                <input type="file" name="photo" accept="image/*" hidden>
                Téléverser la photo
            </label>

            <label class="album-edit-label">Genre</label>
            <select name="id_genre" class="album-edit-select">
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id_genre }}" {{ $album->chansons->first()?->id_genre == $genre->id_genre ? 'selected' : '' }}>
                        {{ $genre->genre }}
                    </option>
                @endforeach
            </select>

            <label class="album-edit-label">Artiste</label>
            <select name="id_artiste" class="album-edit-select">
                @foreach ($artistes as $artiste)
                    <option value="{{ $artiste->id }}" {{ $album->chansons->first()?->id_artiste == $artiste->id ? 'selected' : '' }}>
                        {{ $artiste->name }}
                    </option>
                @endforeach
            </select>

            <div class="album-edit-actions">
                <button type="submit" class="btn-save">Sauvegarder</button>
            </div>
        </form>

        {{-- Delete album --}}
        <form method="POST" action="{{ route('albums.destroy', $album) }}" style="margin-top: 0.5rem;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete"
                    onclick="return confirm('Etes-vous sûr de vouloir supprimer l\'album « {{ $album->nom }} » ?')">
                    Supprimer
            </button>
        </form>

        {{-- Tracks --}}
        <h2 style="margin: 1.5rem 0 0.5rem;">Tracks</h2>
        <div class="album-tracks">
            @foreach ($album->chansons as $chanson)
            <div class="album-track-row">
                <span>{{ $chanson->nom }}</span>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <a href="{{ route('chansons.edit', $chanson) }}" style="color: #dbe7ff;">✏️</a>
                    <form method="POST" action="{{ route('chansons.retirerAlbum', $chanson) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-track-delete"
                                onclick="return confirm('Etes-vous sûr de vouloir retirer la chanson « {{ $chanson->nom }} » de cet album ?')">
                                ✖
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection

