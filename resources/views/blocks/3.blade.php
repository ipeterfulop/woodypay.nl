<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col md:flex-row w-full justify-between"  style="{{ $block->styledefinitions->getStyleString() }}; background-size: cover">
        <div class="w-full md:w-1/2 flex-col items-end justify-center py-16">
            <div class="overflow-x-hidden w-full h-full flex items-center justify-end" @if(isset($block->image_container_styledefinitions)) style="{{ $block->image_container_styledefinitions->getStyleString() }}" @endif >
                <img src="{{ $block->image_url }}" class="object-contain rounded-xl">
            </div>
        </div>
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center py-16 px-4">
            <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
            <div class="py-4">{!! $block->content !!}</div>
            @if($block->button_label != null)
                <a href="{{ $block->button_url }}" class="button" style="{{ $block->button_styledefinitions->getStyleString() }}">
                    {{ $block->button_label }}
                </a>
            @endif
        </div>
    </div>
</div>