    <div class="flex flex-col-reverse @if($block->positioning->code == 'left') md:flex-row-reverse @else md:flex-row @endif  w-full justify-between  {{ $block->getBlockCSSName() }}  {{ $block->blocktype->getCSSName() }} @if($block->widthtype == \App\Helpers\Widthtype::FULL_ID) max-width-container @endif"  style="background-size: cover">
        <div class="w-full md:w-1/2 flex flex-col items-start justify-center pb-16 pt-2 lg:py-64 px-4 lg:px-32">
            <h1 class="w-full text-left" style="">{!! $block->title_translated !!}</h1>
            <div class="py-8 leading-6">{!! $block->content_translated !!}</div>
            @if($block->button_label_translated != null)
                <div class="py-4 w-full flex items-center justify-start">
                    <a href="{{ $block->button_url_translated }}" class="button" style=""  @if($block->should_open_button_url_in_new_window == 1) target="_blank" @endif>
                        {{ $block->button_label_translated }}
                    </a>
                </div>
            @endif
        </div>
        <div class="w-full md:w-1/2 flex-col items-end justify-center py-16">
            <div class="overflow-x-hidden w-full h-full flex items-center justify-end px-2" >
                <img src="/storage/attachments/{{ basename($block->topic_image_translated) }}" class="object-contain rounded-xl">
            </div>
        </div>
    </div>
