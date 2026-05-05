<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sonora</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#01060f] text-gray-200">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-[#000d1a]/80 border-b border-white/5 backdrop-blur-xl sticky top-16 md:top-20 z-40">
                    <div class="max-w-7xl mx-auto py-4 md:py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-xl md:text-3xl font-black italic tracking-tight text-white uppercase truncate">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <main class="px-2 sm:px-0">
                @if(session('succes') || session('status'))
                    <div class="max-w-7xl mx-auto px-4 mt-4">
                        <div class="bg-yellow-500 text-black font-bold p-3 md:p-4 rounded-xl md:rounded-2xl shadow-lg text-sm md:text-base">
                            {{ session('succes') ?? session('status') }}
                        </div>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
