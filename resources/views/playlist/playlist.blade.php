<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail d\'une playlist') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    {{-- check si tes ladmin ou cest ta playlist --}}
                    @if(Auth::check() && (Auth::id() == $playlist->id_creator
                    || Auth::user()->is_admin))
                    <form method="get" action="{{ route('modificationPlaylist') }}">
                    @csrf
                    <button type="submit" name="id_playlist" value="{{ $playlist->id_playlist }}" class="w-5 mx-2">
                    Modifier
                    </button>
                    </form>
                    @endif
                    <h3 class="font-semibold text-lg">Playlist - {{ $playlist->playlist }}</h3> {{-- Recupere le nom de la playlist (laribue playlist) --}}
                    <p class="font-normal"><span class="font-semibold">Createur :</span> {{-- Dire genre moi meme si le id est pareil --}}
                    {{ $playlist->id_creator }}</p> {{-- Dire genre moi meme si le id est pareil --}}
                    {{ $playlist->user->name }}</p>
                    <p class="font-normal"><span class="font-semibold">Description :</span>
                    {{ $playlist->description }}</p>
                    @if ($playlist->link != '')
                    <a href="/link/{{$playlist->link}}" class="font-normal"><span class="font-semibold">Link :</span> {{-- Faire un if else pour voir si cest public ou pas si cest public copier le link --}}
                    {{ 'localhost/link/' . $playlist->link }} </a>
                    @endif
                    @if ($playlist->chansons->isNotEmpty())
                        <h1 class="font-semibold"> Chansons </h1>
                            @foreach ($playlist->chansons as $chanson)
                                <p>Titre : {{ $chanson->nom }}</p>
                                <p>Ajoutée le : {{ $chanson->pivot->date_ajout }}</p>
                            @endforeach
                    @else
                        <h1 class="font-semibold"> Aucune chansons </h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
