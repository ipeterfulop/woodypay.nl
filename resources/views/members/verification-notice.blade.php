@extends('layouts.app')
@section('content')
    <div class="bg-gray-100">
        @if(isset($verificationLinkSent))
            <form method="post" action="{{ route('verification.link') }}" class="flex flex-col items-center justify-start">
                @csrf
                @lang('Elküldtük a megerősítéshez szükséges hivatkozást. Ha újra szeretné küldeni, kattintson az alábbi gombra.')
                <button type="submit">@lang('Link küldése')</button>
            </form>
        @else
            <form method="post" action="{{ route('verification.link') }}" class="flex flex-col items-center justify-start">
                @csrf
                @lang('A funkció használatához kérjük erősítse meg e-mailcímét az alábbi gombra kattintva.')
                <button type="submit">@lang('Link küldése')</button>
            </form>
        @endif
    </div>
@endsection