<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col items-center justify-start px-4 lg:px-32 {{ $block->getBlockCSSName() }} {{ $block->blocktype->getCSSName() }}"
         style="background-repeat:no-repeat; background-position: bottom left; {{ $block->spacingCssStyle() }}">
        <h1 class="w-full text-center px-3 text-2xl lg:text-5xl" style="">{!! $block->title_translated !!}</h1>
        <div class="py-8 text-xl">{!! $block->content_translated !!}</div>
        @if($block->button_label_translated != null)
            <a href="{{ $block->button_url_translated }}" class="button"
               @if($block->should_open_button_url_in_new_window == 1) target="_blank" @endif>
                {{ $block->button_label_translated }}
            </a>
        @endif
    </div>
</div>