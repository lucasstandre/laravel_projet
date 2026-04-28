<x-app-layout>
    <div class="py-12 bg-[#000d1a] min-h-screen text-white">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#001a33] rounded-[2.5rem] p-10 border border-white/5 shadow-2xl">

                <h2 class="text-3xl font-bold italic tracking-tight mb-8 border-b border-white/10 pb-4">
                    {{ __('Éditer la playlist') }}
                </h2>

                <form method="post" action="{{ route('enregistrementPlaylist') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="id_playlist" value="{{ $playlist->id_playlist }}">

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2" for="playlist">
                            Nom de la playlist
                        </label>
                        <input class="w-full bg-black/30 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-yellow-500 focus:ring-0 transition-all"
                               id="playlist" name="playlist" type="text" value="{{ $playlist->playlist }}">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2" for="description">
                            Description
                        </label>
                        <textarea class="w-full bg-black/30 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-yellow-500 focus:ring-0 transition-all"
                                  id="description" name="description" rows="4">{{ $playlist->description }}</textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button class="flex-1 bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-widest py-4 rounded-2xl transition-all shadow-lg shadow-yellow-500/20"
                                type="submit">
                            Enregistrer les modifications
                        </button>
                        <a href="{{ url()->previous() }}" class="px-8 py-4 text-gray-400 font-bold hover:text-white transition-all text-sm">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
