<div class="w-full max-width-container flex items-start justify-center" x-data="{'currentItem': 0}">
    <div class="flex flex-col-reverse md:flex-row w-full justify-between"  style="{{ $block->styledefinitions->getStyleString() }}; background-size: cover">
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center py-16 px-4">
            <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
            <div class="py-4">{!! $block->content !!}</div>
            <ul class="flex items-start justify-start flex-col">
                @foreach($block->items as $index => $item)
                    <li class="flex flex-col items-stretch justify-start py-2"
                        data-block-id="{{ $index }}"
                        data-image-url="{{ $item->image_url }}"
                        x-ref="listitem-{{ $block->id.'-'.$index }}"
                    >
                        <h3 class="cursor-pointer" @click="currentItem = {{ $index }}"
                        >{{ $item->title }}</h3>
                        <div x-show="currentItem == {{ $index }}">{!! $item->content !!}</div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full md:w-1/2 flex-col items-end justify-center py-16">
            <div class="overflow-x-hidden w-full h-full flex items-center justify-end" @if(isset($block->image_container_styledefinitions)) style="{{ $block->image_container_styledefinitions->getStyleString() }}" @endif >
                <img :src="$refs['listitem-{{ $block->id }}-'+currentItem.toString()].getAttribute('data-image-url')" class="object-contain rounded-xl">
            </div>
        </div>
    </div>
</div>