@extends('mail.layout')
@section('title')
    @lang('Új jelszó igénylése')
@endsection
@section('content')
    <h2>@lang('Tisztelt felhasználónk!')</h2>
    <p>@lang('Az Ön részére a :email címhez tartozó fiókon ön, vagy valaki más jelszó-módosítást kezdeményezett a :app rendszerben.', ['email' => $user->email, 'app' => config('app.name') ])</p>
    <p>@lang('Ha nem ön volt az, ezt az üzenetet figyelmen kívül hagyhatja, a fiókja biztonságban van.')</p>
    <p>@lang('Jelszava megváltoztatásához kattintson az alábbi linkre:')</p>
    <p style="text-align: center; margin-top: 20px"><a style="width: 50%; background-color: #3e9cb9; padding: 10px; color:white" href="{{ $url }}">@lang('Új jelszó')</a></p>
@endsection
@section('footer')
    {{ config('app.name') }}
@endsection
