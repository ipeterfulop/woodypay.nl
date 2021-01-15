    <div class="flex flex-col items-center justify-start py-16 lg:py-32 px-4 lg:px-32 {{ $block->getBlockCSSName() }} {{ $block->blocktype->getCSSName() }}" style="background-size: cover">
        <h1 class="w-full text-center text-3xl lg:text-5xl" style="">{!! $block->title_translated !!}</h1>
        <div class="w-full flex items-center justify-center py-10">
            <div style="height: 2px; width: 6rem" class="bg-gray-900">&nbsp;</div>
        </div>
        <div class="py-8 px-16">{!! $block->content_translated !!}</div>
        <div class="py-4 w-full flex flex-col md:flex-row items-center justify-center px-0 md:px-16 ">
            <div class="w-full md:w-1/3 flex items-center">
                <img src="/storage/attachments/{{ basename($block->person_photo) }}" class="w-full object-contain">
            </div>
            <div class="w-full md:w-1/3 pt-4 md:pt-0 flex flex-row items-stretch justify-start lg:justify-center pl-8 lg:pl-0">
                <div class="flex h-full flex-col items-start justify-start pr-3 pt-3 lg:pt-5">
                    <span style="height: 2px; width: 1.5rem" class="bg-gray-900">&nbsp;</span>
                </div>
                <div class="flex h-full flex-col items-start lg:items-center justify-center">
                    <div class="font-light text-xl lg:text-3xl">{{ $block->person_first_name_translated }}&nbsp;{{ $block->person_last_name_translated }}</div>
                    <div class="opacity-50">{{ $block->person_position_translated }}</div>
                </div>
            </div>
        </div>
        @if($block->button_label_translated != null)
            <a href="{{ $block->button_url_translated }}" class="button mt-8" style="">
                {{ $block->button_label_translated }}
            </a>
        @endif
    </div>
