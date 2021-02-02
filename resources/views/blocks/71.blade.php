    <div class="flex flex-col items-start justify-start px-32 {{ $block->getBlockCSSName() }} {{ $block->blocktype->getCSSName() }} pb-16 @if($block->widthtype == \App\Helpers\Widthtype::FULL_ID) max-width-container @endif"
         x-data="{'currentTab': 0}"
         style="background-size: cover">
        <h1 class="w-full text-center pb-12" style="">{!! $block->title_translated !!}</h1>
        <div class="w-full text-center px-3 py-3" style="">{!! $block->content_translated !!}</div>
        @foreach($block->getLists() as $tabIndex => $tab)
            @push('tabs-'.$block->id)
                <div class="text-xl lg:text-3xl cursor-pointer p-6 w-1/{{ count($block->lists) }}"
                     data-tab-id="{{ $tabIndex }}"
                     @click="currentTab = {{ $tabIndex }}"
                     x-bind:class="{'active-tab': currentTab == {{ $tabIndex }}, 'inactive-tab': currentTab != {{ $tabIndex }}}"
                >{{ $tab->title_translated }}</div>
            @endpush
            @push('tabcontent-'.$block->id)
                <div class="w-full flex flex-row items-start justify-between p-4"
                     x-show="currentTab == {{ $tabIndex }}"
                     x-bind:class="{'active-tab-content': currentTab == {{ $tabIndex }}}"
                >
                    <div class="w-1/2 flex flex-col px-12">
                        @foreach($tab->items as $index => $item)
                            @if($item->fa_icon_classes != null)
                                <i class="fa {{ $item->fa_icon_classes }} mb-4"  style="width: 3rem; height: 3rem"></i>
                            @else
                                <img src="/storage/attachments/{{ basename($item->image_url) }}" class="h-16">
                            @endif
                            <h3 class="pb-1">{{ $item->title_translated }}</h3>
                            <div class="font-light tracking-normal mb-16">{!! $item->content_translated !!}</div>
                        @endforeach
                    </div>
                    <div class="w-1/2">
                        <img src="/storage/attachments/{{ basename($tab->topic_image_translated) }}" class="object-contain">
                    </div>
                </div>
            @endpush
            @push('tabcontent-mobile-'.$block->id)
                <h3 class="font-bold text-center py-8">{{ $tab->title_translated }}</h3>
                <div class="w-full flex flex-col items-start justify-start p-4 mb-4">
                    <img class="w-full object-contain" src="/storage/attachments/{{ basename($tab->image_url) }}">
                </div>
                <div class="w-full flex flex-col items-center">
                    @foreach($tab->items as $index => $item)
                        <img src="{{ $item->image_url }}" class="h-16">
                        <h3 class="font-bold">{{ $item->title_translated }}</h3>
                        <div class="font-light tracking-normal mb-6">{!! $item->content_translated !!}</div>
                    @endforeach
                </div>
            @endpush
        @endforeach
        <div class="hidden md:flex w-full flex-row items-between justify-between mt-4">
            @stack('tabs-'.$block->id)
        </div>
        <div class="hidden md:flex w-full">
            @stack('tabcontent-'.$block->id)
        </div>
        <div class="flex md:hidden w-full flex-col">
            @stack('tabcontent-mobile-'.$block->id)
        </div>
    </div>
