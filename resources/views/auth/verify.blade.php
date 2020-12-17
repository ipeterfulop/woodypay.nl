@extends('layouts.app', ['showHeader' => false])

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                @includeIf('tailwindui.customizations.login-window-head')
            </div>
            <div>
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    @lang('E-mailcím megerősítése')
                </h2>
            </div>
            @if (session('resent'))
                <div class="rounded-md shadow-sm p-1 py-2 mt-2 bg-green-700 text-white text-center" role="alert">
                    {{ __('A megadott címre elküldtük a megerősítő hivatkozást.') }}
                </div>
            @endif
            <form class="mt-8" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    {{ __('Kattintson ide új hivatkozás igényléséhez') }}
                </button>.
            </form>

        </div>
    </div>
@endsection

