<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kunjungan Sales') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|space-grotesk:500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 bg-paper">
            <a href="/" class="flex items-center gap-2.5">
                <div class="h-11 w-11 rounded-lg bg-ink flex items-center justify-center font-display font-semibold text-white">KS</div>
                <span class="font-display font-semibold text-xl text-ink tracking-tight">Kunjungan Sales</span>
            </a>

            <div class="w-full sm:max-w-md mt-8 px-6 py-6 bg-white shadow-sm border border-gray-100 overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
