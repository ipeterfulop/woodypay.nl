<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col items-start justify-start py-16 px-4" style="{{ $block->styledefinitions->getStyleString() }}; background-size: cover">
        <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
        <div class="p-4 flex flex-row flex-wrap items-start justify-start">
            @foreach($block->items as $index => $item)
                <div class="w-full md:w-1/2 lg:w-1/3 flex flex-col items-start justify-start p-4">
                    <img src="{{ $item->image_url }}" class="h-16">
                    <h3>{{ $item->title }}</h3>
                    <div>{!! $item->content !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>