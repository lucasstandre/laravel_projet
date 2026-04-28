@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier un réseau social</h1>

    <form action="{{ route('mediasociaux.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        @include('mediasociaux.partials.form', ['item' => $item])
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('mediasociaux.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
