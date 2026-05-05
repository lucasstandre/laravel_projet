@extends('layouts.main')

@section('title', 'Settings')

@section('content')
<style>
    .create-page { background: #0a1628; min-height: 100vh; display: flex; }
    .create-sidebar { width: 150px; background: #0d1f3c; padding: 1.5rem 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
    .create-sidebar .brand { color: #ffc500; font-weight: 800; font-style: italic; font-size: 1.1rem; margin-bottom: 1.5rem; }
    .create-sidebar a { color: rgba(219, 231, 255, 0.6); text-decoration: none; padding: 0.4rem 0.5rem; border-radius: 6px; font-size: 0.9rem; }
    .create-sidebar a:hover { color: #dbe7ff; }
    .create-sidebar a.active { color: #dbe7ff; background: rgba(126, 162, 211, 0.15); }
    .create-main { flex: 1; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; }
    .create-field { width: 100%; padding: 1.2rem; border-radius: 8px; border: none; background: #112240; color: #dbe7ff; font-size: 1rem; box-sizing: border-box; }
    .create-field::placeholder { color: rgba(219, 231, 255, 0.4); }
    .create-field:focus { outline: none; background: #163060; }
    .btn-delete { padding: 1rem; border-radius: 8px; border: none; background: rgba(255, 80, 80, 0.3); color: #ffaaaa; font-size: 1rem; font-weight: 700; cursor: pointer; width: 100%; }
    .btn-delete:hover { background: rgba(255, 80, 80, 0.5); }
</style>

<div class="create-page">

    <div class="create-sidebar">
        <div class="brand">ArtistHub</div>
        <a href="#">Profile</a>
        <a href="{{ route('chansons.create') }}">Musique</a>
        <a href="#">Analytics</a>
        <a href="{{ route('settings') }}" class="active">Settings</a>
    </div>

    <div class="create-main">
        <h2 style="color: #dbe7ff; margin: 0;">Paramètres du compte</h2>

        <div style="background: rgba(255, 80, 80, 0.1); border: 1px solid rgba(255, 80, 80, 0.3); border-radius: 8px; padding: 1.5rem;">
            <h3 style="color: #ffaaaa; margin: 0 0 1rem;">Supprimer mon compte</h3>
            <p style="color: rgba(219, 231, 255, 0.6); margin: 0 0 1rem;">Cette action est irréversible.</p>

            <form method="POST" action="{{ route('account.destroy') }}">
                @csrf
                @method('DELETE')

                <input type="password" name="password" placeholder="Confirmer votre mot de passe" class="create-field" style="margin-bottom: 1rem;">

                @if ($errors->has('password'))
                    <p style="color: #ffaaaa; margin: 0 0 1rem;">{{ $errors->first('password') }}</p>
                @endif

                <button type="submit" class="btn-delete">Supprimer mon compte</button>
            </form>
        </div>
    </div>

</div>
@endsection

