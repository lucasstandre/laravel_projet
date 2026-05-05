<x-app-layout>
    <div class="py-12 bg-[#000d1a] min-h-screen text-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-[#001a33] p-6 rounded-[2rem] border border-white/5 shadow-lg">
                <h2 class="text-3xl font-bold italic tracking-tight">{{ __('Playlists') }}</h2>

                <div class="flex items-center gap-4">
                    <x-search-bar action="/playlists" placeholder="Chercher..." />
                    <form action="/playlists" method="GET">
                        <x-filtre
                            name="original"
                            label="Filtre"
                            :options="[1 => 'Originale', 0 => 'Partagée']"
                        />
                    </form>
                </div>
            </div>

            <div class="space-y-4">
                @foreach ($playlists as $playlist)
                    <div class="bg-gradient-to-r from-[#111827] to-[#001a33] p-6 rounded-3xl border border-white/5 flex items-center justify-between group hover:border-yellow-500/50 transition-all shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="bg-yellow-500/10 p-3 rounded-2xl">
                                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold tracking-tight">{{ $playlist->playlist }}</h3>
                                <p class="text-xs text-gray-500 uppercase font-black tracking-widest mt-1">
                                    {{ $playlist->user->name ?? 'Système' }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('playlist', ['id' => $playlist->id_playlist]) }}"
                           class="bg-white/5 hover:bg-yellow-500 hover:text-black px-6 py-2 rounded-full font-bold text-sm transition-all border border-white/10">
                            {{ __('Ouvrir') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
