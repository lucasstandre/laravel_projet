<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sonora - Connexion</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#01060f]">
        <div class="min-h-screen flex flex-col md:flex-row">
            <div class="hidden md:flex flex-col justify-center p-12 lg:p-24 bg-gradient-to-br from-[#fcd34d] via-[#b45309] to-[#000d1a] w-1/2 relative">
                <div class="relative z-10">
                    <h1 class="text-6xl lg:text-8xl font-black tracking-tighter text-white mb-6">SONORA</h1>
                    <p class="text-white/80 text-xl lg:text-2xl italic leading-tight">L'expérience musicale ultime.</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 flex items-center justify-center p-4 sm:p-8 bg-[#01060f]">
                <div class="w-full max-w-md">
                    <div class="text-center mb-8 md:hidden">
                        <h1 class="text-4xl font-black tracking-tighter text-yellow-500">SONORA</h1>
                    </div>
                    <div class="bg-[#000d1a] p-6 sm:p-10 rounded-[2rem] sm:rounded-[3rem] border border-white/5 shadow-2xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
