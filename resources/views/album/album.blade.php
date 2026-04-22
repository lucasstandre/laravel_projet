@extends('layouts.main')

@section('title', $album->nom)

@section('content')
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff;">
    <div style="max-width: 700px; margin: 0 auto;">
        <h1>{{ $album->nom }}</h1>
        <p>Album name : {{ $album->nom }}</p>
        <p>Genre : {{ $album->chanson->genre }}</p>
        <p>Artist : {{ $album->$chanson->user->name }}</p>
        <p>Tracks : {{ $albums->date_sortie }}</p>

        <a href="{{ route('albums.edit', $albums) }}">Modifier</a>
        {{-- Pour delete la musique qu'on est dedans --}}
        <form method="POST" action="{{ route('albums.destroy', $albums) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>

        <a href="{{ route('albums') }}">Retour</a>
    </div>
</div>
@endsection
