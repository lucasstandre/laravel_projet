@extends('layouts.main')

@section('title', 'Ajouter une chanson')

@section('content')
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff;">
    <div style="max-width: 700px; margin: 0 auto;">
        <h1 style="margin: 0 0 1rem;">Ajouter une chanson</h1>

        @if ($errors->any())
            <div style="margin-bottom: 1rem; padding: 0.8rem 1rem; border-radius: 8px; background: rgba(255, 122, 122, 0.2); border: 1px solid rgba(255, 122, 122, 0.5); color: #ffdede;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('chansons.store') }}" style="display: grid; gap: 0.8rem;">
            @csrf
            <input type="text" name="nom" placeholder="Nom" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="text" name="duree" placeholder="Duree" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="text" name="description" placeholder="description" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="date" name="date_sortie" placeholder="date de sortie" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="text" name="fichier" placeholder="fichier" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <select name="id_album" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <option value="">-- Choisir un album --</option>
                @foreach ($albums as $album)
                    <option value="{{ $album->id_album }}">{{ $album->nom }}</option>
                @endforeach
            </select>

            <select name="id_genre" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
                <option value="">-- Choisir un genre --</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id_genre }}">{{ $genre->genre }}</option>
                @endforeach
            </select>

            <select name="id_artiste" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
                <option value="">-- Choisir un artiste --</option>
                @foreach ($artistes as $artiste)
                    <option value="{{ $artiste->id }}">{{ $artiste->name }}</option>
                @endforeach
            </select>

            <div style="display: flex; gap: 0.7rem; margin-top: 0.5rem;">
                <button type="submit" style="padding: 0.7rem 1rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer;">Enregistrer</button>
                <a href="{{ route('chansons.store') }}" style="padding: 0.7rem 1rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.4); color: #dbe7ff; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
