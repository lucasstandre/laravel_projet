{{-- Voici une blade quon peut reutiliser dans toute les route pour search yk --}}
{{-- LES CLASSE SONT A CHANGER POUR LE CSSS --}}
<div class="filter-group">
    <label for="{{ $name }}">{{ $label }}</label>

    <select name="{{ $name }}" id="{{ $name }}" onchange="this.form.submit()"> {{-- chaque fois quon change le select boom send --}}

        {{-- option de base pour selectionner tout les ex : type, genre etc --}}
        <option value="">Tous les {{ $label }}s</option>
        {{-- Faire un if else pour s  --}}
        {{-- for loop pour tout les options qui se displays --}}
        @foreach($options as $value => $display)
            <option value="{{ $value }}"
                   {{-- si le name est la value met le en selected --}}
                    @if(request($name) == $value)
                        selected
                    @endif
                >
                    {{ $display }}
                </option>
        @endforeach
    </select>
</div>
