@extends('tailwindui.layouts.admin-left-menu.app')
@section('content')
    <div class="bg-gray-100">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            Admin home
        </div>
        <color-picker :value="'#846c6c'" :presets="{{ json_encode([['label' => 'Blue', 'value' => '#06579D'], ['label' => 'Black', 'value' => '#000000']]) }}"></color-picker>
    </div>
@endsection
