    <div class="flex flex-col items-center justify-start py-16 lg:py-40 px-4 lg:px-32 {{ $block->getBlockCSSName() }} {{ $block->blocktype->getCSSName() }} @if($block->widthtype == \App\Helpers\Widthtype::FULL_ID) max-width-container @endif" style="background-repeat:no-repeat; background-position: bottom left">
        <h1 class="w-full text-center px-3  text-3xl lg:text-7xl" style="">{!! $block->title_translated !!}</h1>
        <div class="py-16 text-lg lg:text-3xl font-light lg:tracking-tight w-full lg:w-1/2 text-center">{!! $block->content_translated !!}</div>
        @if($block->button_label_translated != null)
            <a href="{{ $block->button_url_translated }}" class="button"
               @if($block->should_open_button_url_in_new_window == 1) target="_blank" @endif>
                {{ $block->button_label_translated }}
            </a>
        @endif
    </div>
