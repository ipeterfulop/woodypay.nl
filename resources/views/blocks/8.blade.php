<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>
<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col items-center justify-start py-16 px-4 {{ $block->getBlockCSSName() }}" style="background-size: cover">
        <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
        <div class="py-4">{!! $block->content !!}</div>
        <div class="py-4 w-full flex flex-col md:flex-row items-center justify-center px-0 md:px-16 ">
            <div class="w-full md:w-1/3 flex items-center">
                <img src="{{ $block->person_photo }}" class="w-full object-contain">
            </div>
            <div class="w-full md:w-1/3 pt-4 md:pt-0 flex flex-row items-center justify-center">
                <div class="hidden md:flex h-full w-1/4 flex-col items-center justify-center text-3xl">-</div>
                <div class="flex h-full w-full md:w-3/4 flex-col items-center justify-center">
                    <div>{{ $block->person_first_name }}&nbsp;{{ $block->person_last_name }}</div>
                    <div>{{ $block->person_position }}</div>
                </div>
            </div>
        </div>
        @if($block->button_label != null)
            <a href="{{ $block->button_url }}" class="button" style="">
                {{ $block->button_label }}
            </a>
        @endif
    </div>
</div>