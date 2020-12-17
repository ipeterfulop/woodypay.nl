@extends('layouts.app')
@section('content')
    {{ $exception->getMessage() }}
@endsection