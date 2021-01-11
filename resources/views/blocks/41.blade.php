<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col items-start justify-start py-32 px-4  {{ $block->getBlockCSSName() }} {{ $block->blocktype->getCSSName() }}" style="background-size: cover">
        <h1 class="w-full text-center px-2 lg:px-16  text-3xl lg:text-5xl" style="">{!! $block->getItemsContainer()->title_translated !!}</h1>
        <div class="py-4 px-8 lg:px-48 text-center lg:text-left">{!! $block->getItemsContainer()->content_translated !!}</div>
        <div class="p-4 px-8 lg:px-48 flex flex-row flex-wrap items-start justify-start">
            @foreach($block->getItemsContainer()->items as $index => $item)
                <div class="w-full md:w-1/2 flex flex-col items-start justify-start px-8 py-4 lg:py-16 mt-4">
                    @if($item->fa_icon_classes != null)
                        <i class="fa {{ $item->fa_icon_classes }} mb-4"  style="width: 3rem; height: 3rem"></i>
                    @else
                        <img src="{{ $item->image_url }}" class="h-16">
                    @endif
                    <h3 class="text-3xl pb-1">{{ $item->title_translated }}</h3>
                    <div>{!! $item->content_translated !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>