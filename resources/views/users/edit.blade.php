@extends('layouts.main')

@section('title', 'Modifier un utilisateur')

@section('content')
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); min-height: 100vh; padding: 2rem; color: #dbe7ff;">
    <div style="max-width: 700px; margin: 0 auto;">
        <h1 style="margin: 0 0 1rem;">Modifier {{ $user->name }}</h1>

        @if ($errors->any())
            <div style="margin-bottom: 1rem; padding: 0.8rem 1rem; border-radius: 8px; background: rgba(255, 122, 122, 0.2); border: 1px solid rgba(255, 122, 122, 0.5); color: #ffdede;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user) }}" style="display: grid; gap: 0.8rem;">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Nom" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="text" name="country" value="{{ old('country', $user->country) }}" placeholder="Pays" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="password" name="password" placeholder="Nouveau mot de passe (optionnel)" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">
            <input type="password" name="password_confirmation" placeholder="Confirmer le nouveau mot de passe" style="padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff;">

            <div style="display: flex; gap: 0.7rem; margin-top: 0.5rem;">
                <button type="submit" style="padding: 0.7rem 1rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer;">Sauvegarder</button>
                <a href="{{ route('users.show', $user) }}" style="padding: 0.7rem 1rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.4); color: #dbe7ff; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
