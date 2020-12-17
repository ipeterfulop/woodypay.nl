@extends('layouts.app')
@section('content')
    <div class="bg-gray-100">
        Név: {{ \Auth::user()->name }}
    </div>
@endsection