<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SHIIS Reunion') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .auth-bg {
                background: radial-gradient(circle at top right, #14532d, #064e3b, #022c22);
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased auth-bg min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8 transform hover:scale-110 transition duration-500">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" class="w-32 h-32 rounded-full border-4 border-white/20 shadow-2xl shadow-green-900/50" />
                </a>
            </div>

            <div class="w-full sm:max-w-xl mt-6 px-8 py-10 bg-white/95 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-3xl border border-white/20">
                {{ $slot }}
            </div>

            <div class="mt-8 text-white/60 text-sm">
                &copy; 2026 SHIIS Class of 2005. Stronger Together.
            </div>
        </div>
    </body>
</html>
