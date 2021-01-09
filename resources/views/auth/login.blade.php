@extends('layouts.app', ['showHeader' => false])

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                @includeIf('tailwindui.customizations.login-window-head')
                <div class="font-bold text-center w-full">{{ config('app.name') }}</div>
            </div>
            <form class="mt-8" action="{{ route('login') }}" method="POST">
                @csrf
                <input type="hidden" name="remember" value="true" />
                <div class="rounded-md shadow-sm">
                    <div>
                        <input aria-label="@lang('E-mail')" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 @error('email') is-invalid @enderror" placeholder="@lang('E-mail')" value="{{ old('email') }}"/>
                    </div>
                    <div class="-mt-px">
                        <input aria-label="@lang('Password')" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 @error('password') is-invalid @enderror" placeholder="@lang('Password')" />
                    </div>
                </div>

                @error('email')
                <div class="rounded-md shadow-sm p-1 py-2 mt-2 bg-white">
                <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                </div>
                @enderror

                @error('password')
                <div class="rounded-md shadow-sm p-1 py-2 mt-2 bg-white">
                <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                </div>
                @enderror

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                        <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                            @lang('Remember me')
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            @lang('Forgot your password?')
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400 transition ease-in-out duration-150" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
                        @lang('Login')
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
