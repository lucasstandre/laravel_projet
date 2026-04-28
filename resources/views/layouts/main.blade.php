<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sonora')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: sans-serif; margin: 0; min-height: 100vh; background: #01060f;">
    @include('layouts.navigation')
    @yield('content')
</body>
</html>
