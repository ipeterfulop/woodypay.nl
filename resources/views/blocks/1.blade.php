<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>
<div class="w-full max-width-container flex items-start justify-center {{ $block->getBlockCSSName() }}">
    <div class="flex flex-col items-center justify-start py-16 px-4" style="background-size: cover">
        <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
        <div class="py-4">{!! $block->content !!}</div>
        @if($block->button_label != null)
            <a href="{{ $block->button_url }}" class="button" style="">
                {{ $block->button_label }}
            </a>
        @endif
    </div>
</div>