@extends('layouts.main')

@section('title', 'Afficher une chanson')

@section('content')
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
