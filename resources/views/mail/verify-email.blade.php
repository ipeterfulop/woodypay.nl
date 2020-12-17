@extends('mail.layout')
@section('title')
    @lang('Erősítse meg e-mailcímét')
@endsection
@section('content')
    <h2>@lang('Tisztelt felhasználónk!')</h2>
    <p>@lang('Az alkalmazás használatához kérjük, erősítse meg, hogy az e-mailcíme helyesen lett megadva.')</p>
    <p>@lang('A megerősítéshez kattintson az alábbi linkre:')</p>
    <p style="text-align: center; margin-top: 20px"><a style="width: 50%; background-color: #3e9cb9; padding: 10px; color:white" href="{{ $url }}">@lang('E-mailcím megerősítése')</a></p>
@endsection
@section('footer')
    {{ config('app.name') }}
@endsection
