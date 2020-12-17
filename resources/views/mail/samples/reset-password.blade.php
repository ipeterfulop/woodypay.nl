@extends('mail.layout')
@section('title')
    @lang('Új jelszó igénylése')
@endsection
@section('content')
    <h1>@lang('Tisztelt felhasználónk!')</h1>
    <p>Az Ön részére a {{ $user->email }} címhez tartozó fiókon ön, vagy valaki más jelszó-módosítást kezdeményezett a {{ config('app.name') }} rendszerben.</p>
    <p>Ha nem ön volt az, ezt az üzenetet figyelmen kívül hagyhatja, a fiókja biztonságban van.</p>
    <p>Ha szeretné, jelszavát <a href="{{ route('password.reset', ['token' => $token, 'email' => $user->email]) }}">ide kattintva</a> módosíthatja.</p>
@endsection
@section('footer')
    {{ config('app.name') }}
@endsection
