<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Anahaw Amphitheatre</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-page min-h-screen text-stone-900">
        <main class="mx-auto flex min-h-screen max-w-lg flex-col justify-center px-6 py-12">
            <a class="auth-brand mb-6 flex items-center justify-center gap-3 text-2xl font-semibold" href="/">
                <img class="brand-logo" src="{{ asset('images/anahaw-amphitheatre-logo.jpeg') }}" alt="">
                <span>Anahaw Amphitheatre</span>
            </a>
            <div class="rounded-lg border border-green-100 bg-white p-6 shadow-sm">
                {{ $slot }}
            </div>
        </main>
    </body>
</html>
