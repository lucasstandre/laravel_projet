@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un réseau social</h1>

    <form action="{{ route('mediasociaux.store') }}" method="POST">
        @csrf
        @include('mediasociaux.form', ['item' => null])
        <button class="btn btn-success">Enregistrer</button>
        <a href="{{ route('mediasociaux.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
