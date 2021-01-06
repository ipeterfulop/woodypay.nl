@extends('tailwindui.layouts.admin-left-menu.app', [])
@section('content')
    @if((isset($backlink)) && ($backlink != null))
        <a class="my-4 underline text-blue-400 font-bold" href="{{ $backlink['url'] }}">{{ $backlink['label'] }}</a>
    @endif
    @include('admin.vue-crud.model-manager-inner')
@endsection
