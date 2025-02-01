<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen w-full" x-data="{ show : false}">
        @include('layouts.navigation')
        <div class="flex flex-col flex-1 min-h-screen">
            <header class="flex px-3 py-4 bg-white shadow-md items-center z-10 relative justify-between ">
                <div class="flex">
                    <button @click="show= ! show">
                        <i class="fas fa-chevron-right transform transition-transform duration-500 ease-in-out" :class="show ? 'rotate-180' : 'rotate-0'"></i>
                    </button>
                    <div class="flex ms-4 items-center">
                        @isset($header)
                        <h1>
                            {{$header}}
                        </h1>
                        @endisset
                    </div>
                </div>
                <template x-if="!show">

                    <div class="ms-3 flex">
                        <!-- Settings Dropdown -->
                        <div class="flex">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>
                                            {{
                                        Auth::user()->dataDiri->name ?? Auth::user()->username
                                    }}
                                        </div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </template>
            </header>
            <template x-if="!show">
                <main class="bg-gray-100 flex-1 h-full px-3 py-5">
                    {{ $slot }}
                </main>
            </template>
        </div>
    </div>
    @stack('addedScript')
</body>
</html>
