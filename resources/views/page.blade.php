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
            max-width: 1430px;
        }
        .slider-slide > div {
            height: 100%;
            flex-grow: 1;
        }
    </style>
    <style>
    @foreach($blocks as $block)
        {!! \App\BlockStyledefinition::getCSSClasses($block) !!}
        {!! \App\BlockStyledefinition::getTypeCSSClasses($block->blocktype) !!}
    @endforeach
    </style>
    @foreach($blocks as $block)
        <a name="#block-{{ $block->id }}"></a>
        <div class="block-container block-{{ $block->blocktype_id }}-container"
             @if ($block->blocktype_id == 6)  style="background-color: rgb(58, 70, 101)"  @endif>
            @includeIf('blocks.'.$block->getLayoutName(), ['block' => $block])
        </div>
    @endforeach
@endsection
