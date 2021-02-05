@extends('layouts.app', [
    'pageTitle' => $page->title_translated,
    'pageDescription' => $page->description_translated
])
@section('content')
    <style>
        .max-width-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .max-width-container>:first-child{
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
        >
            <div class="w-full @if($block->widthtype != \App\Helpers\Widthtype::FULL_ID) max-width-container @endif flex items-start justify-center {{ $block->getBlockCSSName() }}container ">
                @includeIf('blocks.'.$block->getLayoutName(), ['block' => $block])

            </div>
        </div>
    @endforeach
@endsection
