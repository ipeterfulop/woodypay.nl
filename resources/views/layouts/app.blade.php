<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div x-data="{showMenu: false}">
        @if((!isset($showHeader)) || ($showHeader))
            <div class="bg-gray-100 w-full flex flex-row items-center justify-end z-40 fixed top-0 left-0">
                <button @click="showMenu = !showMenu">{!! config('heroicons.solid.menu') !!}</button>
            </div>
        @endif
        <main class="py-4">
            @yield('content')
        </main>
        <div id="menu" class="w-0 h-screen z-50 fixed bg-gray-700 bg-opacity-50 right-0 top-0 shadow-xl flex flex-col overflow-hidden transition-opacity duration-100 ease-in-out"
             x-bind:class="{'w-screen opacity-1': showMenu, 'opacity-0': !showMenu}"
             @click.self="showMenu = false"
             >
            <div class="h-screen w-0 fixed right-0 top-0 bg-gray-800 overflow-hidden"
                 style="transition: width 400ms ease-in-out; transition-delay: 0ms"
                 x-bind:class="{'w-11/12 md:w-96': showMenu}">
                <div class="w-full flex items-center justify-end text-white">
                    <button class="p-4 text-5xl flex items-center justify-center focus:outline-none "
                            @click="showMenu = !showMenu">&times;</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.notification')
</body>
</html>
