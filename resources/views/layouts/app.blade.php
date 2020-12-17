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
    <div id="app">
        @if((!isset($showHeader)) || ($showHeader))
            <div class="bg-gray-100 w-full flex flex-row items-center justify-end">
                @auth
                <a href="{{ route('user_profile') }}" class="p-4 mr-4">Profil</a>
                <form method="post" action="/logout">
                    @csrf
                    <button type="submit" class="text-black p-4">@lang('Kijelentkezés')</button>
                </form>
                @endauth
                @guest
                    <a href="/login">@lang('Bejelentkezés')</a>
                @endguest
            </div>
        @endif
        <main class="py-4">
            @yield('content')
        </main>

    </div>
    @include('layouts.partials.notification')
</body>
</html>
