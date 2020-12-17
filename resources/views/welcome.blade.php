@extends('layouts.app')
@section('content')
    <style>
        .max-width-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .max-width-container>:first-child {
            width: 100%;
            max-width: 970px;
        }
    </style>
    @foreach($blocks as $block)
        <a name="#block-{{ $block->id }}"></a>
        <div class="block-container block-{{ $block->blocktype_id }}-container">
            @includeIf('blocks.'.$block->blocktype_id, ['block' => $block])
        </div>
    @endforeach
@endsection
