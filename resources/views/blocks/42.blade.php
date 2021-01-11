<div class="w-full max-width-container flex items-start justify-center" x-data="{'currentItem': 0}">
    <div class="flex flex-col-reverse md:flex-row w-full justify-between {{ $block->getBlockCSSName() }}"   style="background-size: cover">
        <div class="w-full flex flex-col items-start justify-start py-8 lg:py-32 px-4 lg:px-16">
            <h1 class="w-full text-left text-3xl lg:text-5xl" style="">{!! $block->getItemsContainer()->title_translated !!}</h1>
            <div class="py-4">{!! $block->getItemsContainer()->content_translated !!}</div>
            <div class="w-full flex flex-col-reverse lg:flex-row">
                <ul class="w-full lg:w-1/2 flex items-start justify-start flex-col mt-16">
                    @foreach($block->getItemsContainer()->items as $index => $item)
                        <li class="flex flex-col items-stretch justify-start py-8 border-b border-gray-400 w-full"
                            data-block-id="{{ $index }}"
                            data-image-url="{{ (string)$item->image_url == '' ? $item->image_url :  '/storage/attachments/'.$block->getItemsContainer()->topic_image_translated }}"
                            x-ref="listitem-{{ $block->id.'-'.$index }}"
                        >
                            <h3 class="cursor-pointer text-xl font-bold leading-6" @click="currentItem = {{ $index }}"
                            >{{ $item->title_translated }}</h3>
                            <div class="pt-4" x-show="currentItem == {{ $index }}">{!! $item->content_translated !!}</div>
                        </li>
                    @endforeach
                </ul>
                <div class="overflow-x-hidden w-full h-full flex items-center justify-end">
                    <img :src="$refs['listitem-{{ $block->id }}-'+currentItem.toString()].getAttribute('data-image-url')" class="object-contain rounded-xl">
                </div>

            </div>
        </div>
    </div>
</div>