{{-- Voici une blade quon peut reutiliser dans toute les route pour search yk --}}
{{-- LES CLASSE SONT A CHANGER POUR LE CSSS --}}
<form action="{{ $action }}" method="GET" class="search-container">
    <input
        type="text"
        name="search"
        placeholder="{{ $placeholder }}"
        value="{{ request('search') }}"
        class="search-input"
    >
    <button type="submit" class="search-button">
        recherche
    </button>
</form>
