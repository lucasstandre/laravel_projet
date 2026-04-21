<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,600,700,800|manrope:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-shell antialiased">
        <main class="auth-wrapper">
            <section class="auth-brand-panel">
                <a class="auth-brand-link" href="{{ route('home') }}">Sonora</a>
                <p class="auth-brand-copy">Votre appli preferée pour écouter vos musiques préférées</p>
            </section>

            <div class="auth-form-panel">
                <div class="auth-form-slot">

                    <div class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @include('messageFlash')
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </main>
    </body>
</html>
