<x-app-layout>
    <div class="py-12 bg-[#000d1a] min-h-screen text-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-gradient-to-r from-[#fcd34d] via-[#b45309] to-[#000d1a] rounded-[3rem] p-8 flex items-center justify-between shadow-2xl border border-white/10">
                <div class="flex items-center gap-6">
                    <div class="bg-white rounded-2xl p-4 w-20 h-20 flex items-center justify-center shadow-inner">
                        <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 1.119-3 2.5S3.343 19 5 19s3-1.119 3-2.5V8.297l9-1.8V11h-2a1 1 0 100 2h2v3.114l-.196-.039A4.369 4.369 0 0015 16c-1.657 0-3 1.119-3 2.5s1.343 2.5 3 2.5 3-1.119 3-2.5V3z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-5xl font-bold tracking-tighter">{{ $playlist->playlist }}</h1>
                        <p class="text-sm font-black uppercase tracking-widest mt-2 opacity-80">Créé par {{ $playlist->user->name }}</p>
                    </div>
                </div>

                @if(Auth::check() && (Auth::id() == $playlist->id_creator || Auth::user()->role == 1 ))
                <form method="get" action="{{ route('modificationPlaylist') }}">
                    @csrf
                    <button type="submit" name="id_playlist" value="{{ $playlist->id_playlist }}"
                            class="bg-black/40 hover:bg-black px-6 py-2 rounded-full font-bold text-sm border border-white/20 transition-all">
                        Modifier
                    </button>
                </form>
                @endif
            </div>

            <div class="bg-[#001a33] p-8 rounded-[2.5rem] border border-white/5 shadow-lg">
                <h3 class="text-gray-400 text-xs font-black uppercase tracking-widest mb-2">Description</h3>
                <p class="text-lg leading-relaxed mb-6">{{ $playlist->description }}</p>

                @if ($playlist->link != '')
                    <div class="bg-black/20 p-4 rounded-2xl border border-white/5">
                        <p class="text-xs font-bold text-yellow-500 uppercase mb-1">Lien de partage</p>
                        <a href="/link/{{$playlist->link}}" class="text-sky-400 hover:underline break-all">
                            {{ url('/link/' . $playlist->link) }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold italic tracking-tight px-2">{{ __('Titres') }}</h2>
                @forelse ($playlist->chansons as $chanson)
                    <div class="bg-[#111827] p-5 rounded-3xl border border-white/5 flex items-center justify-between hover:bg-[#161e2e] transition-all group">
                        <div class="flex items-center gap-4">
                            <span class="text-gray-600 font-bold w-4 text-center">{{ $loop->iteration }}</span>
                            <div>
                                <p class="font-bold text-gray-200">{{ $chanson->nom }}</p>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Ajoutée le {{ $chanson->pivot->date_ajout }}</p>
                            </div>
                        </div>
                        <div class="bg-white/5 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" /></svg>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-12 bg-[#111827] rounded-3xl border border-dashed border-white/10 text-gray-500">
                        Aucune chanson dans cette playlist.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
