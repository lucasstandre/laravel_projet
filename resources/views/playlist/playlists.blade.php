<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des playlists') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @foreach ($playlists as $playlist)
                        <div>
                            <p class="font-semibold text-lg">{{ $playlist->playlist }} -
                                <a class="font-normal text-base text-sky-700 underline" href="{{
                                route('playlist', ['id' => $playlist->id_playlist]) }}">
                                {{ __('En savoir plus') }}</a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
