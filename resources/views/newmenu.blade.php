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
        <aside class="bg-gray-500 text-white transition-all duration-300 ease-in-out " :class="show ? 'w-1/2 md:w-52' : 'w-0 md:w-16'">
            <template x-if="show">
                <div>
                    <section class="py-5 block bg-white px-3 mb-3">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-6 w-auto fill-current text-gray-800" />
                        </a>
                    </section>
                    <section class="px-3 py-2 space-y-2">
                        <a href="" class="bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Menu 1
                        </a>
                        <div x-data="{show : false}">
                            <button @click="show= ! show" class="px-2 py-2 hover:bg-emerald-500 w-full text-start rounded-md mb-2">Menu Dropdown</button>
                            <div x-show="show" class="ps-3 transition-all duration-500 ease-in-out" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                                <div class="mb-2">
                                    <a href="" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                                        Dropdown Menu 1
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <a href="" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                                        Dropdown Menu 2
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Menu 2
                        </a>
                        <div x-data="{show : false}">
                            <button @click="show= ! show" class="px-2 py-2 hover:bg-emerald-500 w-full text-start rounded-md mb-2">Menu Dropdown</button>
                            <div x-show="show" class="ps-3 transition-all duration-500 ease-in-out" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                                <div class="mb-2">
                                    <a href="" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                                        Dropdown Menu 1
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <a href="" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                                        Dropdown Menu 2
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </template>
            <template x-if="!show">
                <div>
                    <div class="py-5 flex justify-center bg-white px-3 text-black">
                        <span class="block mx-auto"><i class="fas fa-mug-hot"></i></span>
                    </div>
                    <section class="px-3 py-2 space-y-2">
                        <a href="" class="bg-emerald-500 flex justify-center py-2 rounded-md w-full">
                            1
                        </a>
                        <a href="" class="bg-emerald-500 flex justify-center py-2 rounded-md w-full">
                            2
                        </a>
                        <a href="" class="bg-emerald-500 flex justify-center py-2 rounded-md w-full">
                            3
                        </a>
                    </section>
                </div>
            </template>
        </aside>
        <div class="flex flex-col flex-1 min-h-screen">
            <header class="flex px-3 py-4 bg-white shadow-md items-center z-10 relative justify-between ">
                <div class="flex">
                    <button @click="show= ! show">
                        <i class="fas fa-chevron-right transform transition-transform duration-500 ease-in-out" :class="show ? 'rotate-180' : 'rotate-0'"></i>
                    </button>
                    <div class="flex ms-4 items-center">
                        <h1>
                            Header
                        </h1>
                    </div>
                </div>
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
            </header>
            <main class="bg-gray-100 flex-1 h-full px-3 py-5">
                Main Content
            </main>
        </div>
    </div>
</body>
</html>
