@extends('layouts.main')

@section('title', 'Chansons')

@section('content')
<style>
    .chansons-page { background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; }
    .chansons-table { width: 100%; border-collapse: collapse; }
    .chansons-table th, .chansons-table td { padding: 1rem; border: 1px solid rgba(126, 162, 211, 0.2); text-align: center; color: #dbe7ff; }
    .chansons-table thead tr { background: #0d2248; }
    .chansons-table tbody tr { background: #0f2a50; }
    .chansons-table tbody tr:hover { background: #1a3a6a; }
    .chansons-filters { display: flex; gap: 0.75rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .chansons-filters input { padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; }
    .btn-filter { padding: 0.5rem 1.5rem; border-radius: 6px; border: none; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; }
</style>

<div class="chansons-page">
    <form action="/chansons" method="GET" class="chansons-filters">
        <input type="text" name="search" placeholder="Trouver une chanson..." value="{{ request('search') }}">
        <input type="number" name="min_likes" placeholder="Min likes" value="{{ request('min_likes') }}">
        <input type="number" name="min_duree" placeholder="Durée min (sec)" value="{{ request('min_duree') }}">
        <input type="number" name="max_duree" placeholder="Durée max (sec)" value="{{ request('max_duree') }}">
        <button type="submit" class="btn-filter">Filtrer</button>
    </form>

    <table class="chansons-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Durée</th>
                <th>Likes</th>
                <th>Genre</th>
                <th>Artiste</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chansons as $chanson)
            <tr onclick="window.location='{{ route('chansons.edit', $chanson) }}'" style="cursor: pointer;">
                <td>{{ $chanson->nom }}</td>
                <td>{{ $chanson->duree }}s</td>
                <td>{{ $chanson->like }}</td>
                <td>{{ $chanson->genre?->genre ?? 'N/A' }}</td>
                <td>{{ $chanson->user?->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
