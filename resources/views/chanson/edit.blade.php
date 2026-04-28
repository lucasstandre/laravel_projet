@extends('layouts.main')

@section('title', 'Modifier une chansons')

@section('content')
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff;">
    <div style="max-width: 700px; margin: 0 auto;">
        <h1 style="margin: 0 0 1rem;">Modifier {{ $chanson->nom }}</h1>

        @if ($errors->any())
            <div style="margin-bottom: 1rem; padding: 0.8rem 1rem; border-radius: 8px; background: rgba(255, 122, 122, 0.2); border: 1px solid rgba(255, 122, 122, 0.5); color: #ffdede;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('chansons.update', $chanson) }}" style="display: grid; gap: 0.8rem;">
            @csrf
            @method('PUT')

            <a>Nom de la chanson:</a>
            <input type="text" name="nom" placeholder="Nom" value="{{ $chanson->nom }}" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <a>Durée de la chanson:</a>
            <input type="text" name="duree" placeholder="Duree" value="{{ $chanson->duree }}" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <a>Description de la chanson:</a>
            <input type="text" name="description" placeholder="description" value="{{ $chanson->description }}" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <a>Date de sortie de la chanson:</a>
            <input type="date" name="date_sortie" placeholder="date de sortie" value="{{ $chanson->date_sortie }}" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <a>Fichier image de la chanson :</a>
            <input type="text" name="fichier" placeholder="fichier" value="{{ $chanson->fichier }}"" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">

            <a>Album de la chanson</a>
            <select name="id_album" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
                <option value="">-- Choisir un album --</option>
                @foreach ($albums as $album)
                    <option value="{{ $album->id_album }}" {{ $chanson->id_album == $album->id_album ? 'selected' : '' }}>{{ $album->nom }}</option>
                @endforeach
            </select>

            <a>Genre de la chanson</a>
            <select name="id_genre" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
                <option value="">-- Choisir un genre --</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id_genre }}" {{ $chanson->id_genre == $genre->id_genre ? 'selected' : '' }}>{{ $genre->genre }}</option>
                @endforeach
            </select>

            <a>Nom de l'artiste:</a>
            <select name="id_artiste" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
                <option value="">-- Choisir un artiste --</option>
                @foreach ($artistes as $artiste)
                    <option value="{{ $artiste->id }}" {{ $chanson->id_artiste == $artiste->id ? 'selected' : '' }}>{{ $artiste->name }}</option>
                @endforeach
            </select>

            <div style="display: flex; gap: 0.7rem; margin-top: 0.5rem;">
                <button type="submit" style="padding: 0.7rem 1rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer;">Sauvegarder</button>
                <a href="{{ route('chanson', $chanson) }}" style="padding: 0.7rem 1rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.4); color: #dbe7ff; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
