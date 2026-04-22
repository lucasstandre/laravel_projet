@extends('layouts.main')

@section('title', $chanson->nom)

@section('content')
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff;">
    <div style="max-width: 700px; margin: 0 auto;">
        <h1>{{ $chanson->nom }}</h1>
        <p>Durée : {{ $chanson->duree }} secondes</p>
        <p>Description : {{ $chanson->description }}</p>
        <p>Date de sortie : {{ $chanson->date_sortie }}</p>
        <p>Fichier : {{ $chanson->fichier }}</p>
        <p>Album : {{ $chanson->album->nom }} </p>
        <p>Genre : {{ $chanson->genre->genre }} </p>
        <p>Artiste : {{ $chanson->user->name }}</p>

        <a href="{{ route('chansons.edit', $chanson) }}">Modifier</a>
        {{-- Pour delete la musique qu'on est dedans --}}
        <form method="POST" action="{{ route('chansons.destroy', $chanson) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>

        <a href="{{ route('chansons') }}">Retour</a>
    </div>
</div>
@endsection
