@extends('layouts.main')

@section('title', 'Ajouter une chanson')

@section('content')
<style>
    .create-page { background: #0a1628; min-height: 100vh; display: flex; }

    /* Sidebar */
    .create-sidebar { width: 150px; background: #0d1f3c; padding: 1.5rem 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
    .create-sidebar .brand { color: #ffc500; font-weight: 800; font-style: italic; font-size: 1.1rem; margin-bottom: 1.5rem; }
    .create-sidebar a { color: rgba(219, 231, 255, 0.6); text-decoration: none; padding: 0.4rem 0.5rem; border-radius: 6px; font-size: 0.9rem; }
    .create-sidebar a:hover { color: #dbe7ff; }
    .create-sidebar a.active { color: #dbe7ff; background: rgba(126, 162, 211, 0.15); }

    /* Main content */
    .create-main { flex: 1; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; }
    .create-field { width: 100%; padding: 1.2rem; border-radius: 8px; border: none; background: #112240; color: #dbe7ff; font-size: 1rem; box-sizing: border-box; }
    .create-field::placeholder { color: rgba(219, 231, 255, 0.4); }
    .create-field:focus { outline: none; background: #163060; }
    .create-section-title { color: #ffc500; font-weight: 700; font-size: 0.85rem; letter-spacing: 0.08em; text-align: center; }
    .create-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .create-actions { display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-top: 0.5rem; }
    .btn-discard { padding: 1rem; border-radius: 8px; border: none; background: #112240; color: #dbe7ff; font-size: 1rem; cursor: pointer; }
    .btn-upload { padding: 1rem; border-radius: 8px; border: none; background: #ffc500; color: #0b1528; font-size: 1rem; font-weight: 700; cursor: pointer; }
</style>

<div class="create-page">

    {{-- Sidebar --}}
    <div class="create-sidebar">
        <div class="brand">ArtistHub</div>
        <a href="#">Profile</a>
        <a href="#" class="active">Musique</a>
        <a href="#">Analytics</a>
        <a href="{{ route('settings') }}">Settings</a>
    </div>

    {{-- Formulaire --}}
    <div class="create-main">
        <form method="POST" action="{{ route('chansons.store') }}" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf

            {{-- Track name --}}
            <input type="text" name="nom" placeholder="Track name" class="create-field">

            {{-- Music Information --}}
            <div class="create-section-title">INFORMATION DE MUSIQUE</div>

            {{-- Description --}}
            <textarea name="description" placeholder="Description" class="create-field" rows="3"></textarea>

            {{-- MP3 file --}}
            <a style="color: white">Fichier mp3:</a>
            <input type="file" name="fichier" accept="audio/mp3" class="create-field">

            {{-- Durée placeholder --}}
            <input type="number" name="duree" placeholder="Durée (secondes)" class="create-field">

            {{-- Genre + Release date --}}
            <div class="create-row">
                <select name="id_genre" class="create-field">
                    <option value="">Genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id_genre }}">{{ $genre->genre }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_sortie" class="create-field">
            </div>

            {{-- Actions --}}
            <div class="create-actions">
                <a href="{{ route('chansons.create') }}" class="btn-discard" style="text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Tout effacer</a>
                <button type="submit" class="btn-upload">Uploader la musique</button>
            </div>

        </form>
        @if ($errors->any())
            <div style="background: rgba(255, 80, 80, 0.2); border: 1px solid rgba(255, 80, 80, 0.5); color: #ffaaaa; padding: 1rem; border-radius: 8px;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

</div>
@endsection
