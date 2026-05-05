@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Réseaux sociaux</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mediasociaux.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>URL</th>
                <th>Icône</th>
                <th>Actif</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->nom }}</td>
                    <td><a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a></td>
                    <td>{{ $item->icone }}</td>
                    <td>{{ $item->actif ? 'Oui' : 'Non' }}</td>
                    <td>
                        <a href="{{ route('mediasociaux.edit', $item) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('mediasociaux.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune donnée</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $items->links() }}
</div>
@endsection
