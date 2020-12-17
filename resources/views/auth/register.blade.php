@extends('layouts.app', ['showHeader' => false])

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                @includeIf('tailwindui.customizations.register-window-head')
            </div>
            @includeIf('tailwindui.customizations.register-form')
        </div>
    </div>
@endsection
