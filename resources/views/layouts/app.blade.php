@php($siteSettings = \App\Helpers\SiteSettingsFactory::getSiteSettings())
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
    <script src="{{ asset('js/all.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <style>
        .topmenu {
            transition: height 200ms ease-in-out;
            color: white;
        }
        .menubutton {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .menubutton svg {
            height: 100%;
        }
        .topmenu logolink {
            padding-top: .5rem;
            padding-bottom: .5rem;
        }
        .topmenu.menu-shrunk logolink {
            padding-top: 1px;
            padding-bottom: 1px;
        }
    </style>
</head>
<body class="bg-wp-oxfordblue">
    <div x-data="{showMenu: false}">
        @if((!isset($showHeader)) || ($showHeader))
            <div  class="w-full max-width-container flex items-stretch justify-center z-40 fixed top-0 left-0 topmenu h-10"
                  style="height: {{ $siteSettings['page_header.header_height'] }}px; background-color: {{ $siteSettings['page_header.header_background_color'] }}"
                  data-fullheight="{{ $siteSettings['page_header.header_height'] }}"
                  id="topmenu">
                <div class="w-full flex flex-row items-center justify-between self-stretch">
                    <a href="/" class="self-stretch lg:ml-0 logolink">
                        <img src="{{ $siteSettings['page_header.header_logo'] }}" class="self-stretch h-full object-contain">
                    </a>
                    <div class="ml-auto mr-2 md:mr-6 ml-auto flex flex-nowrap items-center justify-end">
                        @foreach(\App\Models\Locale::all() as $locale)
                            <a class="mr-2 font-bold @if($locale->id == \App::getLocale()) opacity-50 @endif" href="/{{$locale->id}}/">{{ mb_strtoupper($locale->id) }}</a>
                        @endforeach
                    </div>
                    <span @click="showMenu = !showMenu" class="cursor-pointer menubutton py-2 focus:outline-none hover:opacity-75 h-full">{!! config('heroicons.solid-nosize.menu') !!}</span>
                </div>
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
        if (entries[0].intersectionRatio == 0) {
            m.classList.add('menu-shrunk');
            m.style.removeProperty('height')
        } else {
            m.classList.add('menu-shrunk');
            m.style.height = m.getAttribute('data-fullheight')+'px'
x        }
    }, {
        root: null,
        rootMargin: '0px',
        threshold: [1,0]
    });
    o.observe(document.getElementById('top'));
</script>
</body>
</html>
