@extends('layouts.main')

@section('title', 'Modifier une chanson')

@section('content')

<style>
    .edit-page { background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff; }
    .edit-container { max-width: 700px; margin: 0 auto; }
    .edit-title { margin: 0 0 1rem; }
    .edit-errors { margin-bottom: 1rem; padding: 0.8rem 1rem; border-radius: 8px; background: rgba(255, 122, 122, 0.2); border: 1px solid rgba(255, 122, 122, 0.5); color: #ffdede; }
    .edit-errors ul { margin: 0; padding-left: 1rem; }
    .edit-form { display: grid; gap: 0.8rem; }
    .edit-label { display: block; color: #dbe7ff; }
    .edit-input, .edit-select { width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; box-sizing: border-box; }
    .edit-input::placeholder { color: rgba(219, 231, 255, 0.4); }
    .edit-actions { display: flex; gap: 0.7rem; margin-top: 0.5rem; }
    .btn-save { padding: 0.7rem 1rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; }
    .btn-cancel { padding: 0.7rem 1rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.4); color: #dbe7ff; text-decoration: none; }
</style>


<div class="edit-page">
    <div class="edit-container">
        <h1 class="edit-title">Modifier {{ $chanson->nom }}</h1>

        @if ($errors->any())
            <div class="edit-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('chansons.update', $chanson) }}" class="edit-form">
            @csrf
            @method('PUT')

            <label class="edit-label">Nom de la chanson :</label>
            <input type="text" name="nom" placeholder="Nom" value="{{ $chanson->nom }}" class="edit-input">

            <label class="edit-label">Durée de la chanson :</label>
            <input type="text" name="duree" placeholder="Durée" value="{{ $chanson->duree }}" class="edit-input">

            <label class="edit-label">Description de la chanson :</label>
            <input type="text" name="description" placeholder="Description" value="{{ $chanson->description }}" class="edit-input">

            <label class="edit-label">Date de sortie de la chanson :</label>
            <input type="date" name="date_sortie" value="{{ $chanson->date_sortie }}" class="edit-input">

            <label class="edit-label">Fichier image de la chanson :</label>
            <input type="text" name="fichier" placeholder="Fichier" value="{{ $chanson->fichier }}" class="edit-input">

            <label class="edit-label">Album de la chanson :</label>
            <select name="id_album" class="edit-select">
                <option value="">-- Choisir un album --</option>
                @foreach ($albums as $album)
                    <option value="{{ $album->id_album }}" {{ $chanson->id_album == $album->id_album ? 'selected' : '' }}>
                        {{ $album->nom }}
                    </option>
                @endforeach
            </select>

            <label class="edit-label">Genre de la chanson :</label>
            <select name="id_genre" class="edit-select">
                <option value="">-- Choisir un genre --</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id_genre }}" {{ $chanson->id_genre == $genre->id_genre ? 'selected' : '' }}>
                        {{ $genre->genre }}
                    </option>
                @endforeach
            </select>

            <label class="edit-label">Nom de l'artiste :</label>
            <select name="id_artiste" class="edit-select">
                <option value="">-- Choisir un artiste --</option>
                @foreach ($artistes as $artiste)
                    <option value="{{ $artiste->id }}" {{ $chanson->id_artiste == $artiste->id ? 'selected' : '' }}>
                        {{ $artiste->name }}
                    </option>
                @endforeach
            </select>

            <div class="edit-actions">
                <button type="submit" class="btn-save">Sauvegarder</button>
                <a href="{{ route('chanson', $chanson) }}" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

