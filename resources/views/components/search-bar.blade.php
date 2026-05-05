{{-- Voici une blade quon peut reutiliser dans toute les route pour search yk --}}
<form action="{{ $action }}" method="GET" class="flex items-center gap-2 w-full max-w-md group">
    <div class="relative flex-1">
        <input
            type="text"
            name="search"
            placeholder="{{ $placeholder }}"
            value="{{ request('search') }}"
            class="w-full bg-black/30 border border-white/10 rounded-2xl py-3 px-5 text-sm text-white placeholder-gray-500 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all outline-none"
        >
        {{-- icone de loup --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 group-focus-within:text-yellow-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-3 px-6 rounded-2xl text-xs uppercase tracking-widest transition-all shadow-lg shadow-yellow-500/10 active:scale-95">
        Recherche
    </button>
</form>
