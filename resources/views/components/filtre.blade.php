{{-- Voici une blade quon peut reutiliser dans toute les route pour search yk --}}
{{-- filtre.blade.php --}}
<div class="flex flex-col gap-1">
    @if(isset($label))
        <label for="{{ $name }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-2">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            onchange="this.form.submit()"
            class="appearance-none w-full bg-black/30 border border-white/10 rounded-2xl py-3 pl-5 pr-10 text-sm text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all outline-none cursor-pointer"
        >
            <option value="" class="bg-[#001a33]">Tous les {{ $label ?? 'filtres' }}</option>

            @foreach($options as $value => $display)
                <option value="{{ $value }}"
                        @if(request($name) !== null && request($name) == $value) selected @endif
                        class="bg-[#001a33]"
                >
                    {{ $display }}
                </option>
            @endforeach
        </select>

        {{-- Petite flèche personnalisée pour remplacer celle du navigateur --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-yellow-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </div>
</div>
