<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>
<body class="flex flex-col items-center min-h-screen justify-center space-y-2">
    <div>
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </div>
    @if (Route::has('login'))
    <nav class="mb-8">
        @auth
        <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2  ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] text-white bg-orange-500 ">
            Dashboard
        </a>
        @else
        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] bg-green-500 text-white">
            Log in
        </a>

        @if (Route::has('register'))
        <a href=" {{ route('register') }}" class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
            Register
        </a>
        @endif
        @endauth
    </nav>
    @endif
    <p class="text-xs">BAM APP <span class="text-slate-400">versi 0.0.0.1-alpha</span></p>
</body>
</html>
