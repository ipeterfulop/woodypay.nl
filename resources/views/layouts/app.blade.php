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
    <style>
        body {
            background-color: rgb(27, 34, 48);
        }
        .topmenu {
            transition: height 200ms ease-in-out; color: white; background-color: rgb(7, 13, 48)
        }
    </style>
</head>
<body>
    <div x-data="{showMenu: false}">
        @if((!isset($showHeader)) || ($showHeader))
            <div class="bg-gray-100 w-full flex flex-row items-center justify-between z-40 fixed top-0 left-0 h-14 topmenu" id="topmenu">
                <a href="/" class="py-2">
                    <img src="/images/assets/logo-ipsum-17.svg" style="height: 100%">
                </a>
                <div class="mr-6 ml-auto">
                    @foreach(\App\Models\Locale::all() as $locale)
                        <a class="mr-2 font-bold @if($locale->id == \App::getLocale()) opacity-50 @endif" href="/{{$locale->id}}/">{{ mb_strtoupper($locale->id) }}</a>
                    @endforeach
                </div>
                <button @click="showMenu = !showMenu" class="focus:outline-none hover:opacity-75 text-3xl">{!! config('heroicons.solid.menu') !!}</button>
            </div>
        @endif
        <main class="py-4" id="content">
            <a name="top" id="top"></a>
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
<script>
    let m = document.getElementById('topmenu');
    let o = new IntersectionObserver((entries, observer) => {
        console.log(entries);
        if (entries[0].intersectionRatio == 0) {
            m.classList.add('h-8');
            m.classList.remove('h-14');
        } else {
            m.classList.add('h-14');
            m.classList.remove('h-8');
        }
    }, {
        root: null,
        rootMargin: '0px',
        threshold: [1,0]
    });
    o.observe(document.getElementById('top'));
</script>
</body>
</html>
