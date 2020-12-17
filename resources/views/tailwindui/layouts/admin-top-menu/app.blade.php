@php
    $showMenu = isset($showMenu) ? $showMenu : \Auth::check();
    $menuitems = isset($menuitems) ? $menuitems : [];
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- any custom links, style definitions or other things in the <head> tag can go into this file -->
@includeIf(config('tailwinduipackage.views.htmlhead'))
<body class="bg-gray-100">
    <div>
        @if($showMenu)
            @include('tailwindui.layouts.admin-top-menu.nav', ['menuitems' => $menuitems])
        @endif
        @if((!isset($disableHeader)) || (!$disableHeader))
            <header class="bg-white shadow-sm">
                <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-lg leading-6 font-semibold text-gray-900">
                        @yield('header')
                    </h1>
                </div>
            </header>
        @endif
        <main  id="app">
            <div class="mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- this will be included after the main content, outside of vue.js's app scope. perfect place for extra script initializations for example -->
    @includeIf('tailwindui.customizations.layout-end')

</body>
</html>
