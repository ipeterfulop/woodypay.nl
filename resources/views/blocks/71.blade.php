<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>

<div class="w-full max-width-container flex items-start justify-center" x-data="{'currentTab': 0}">
    <div class="flex flex-col items-start justify-start pb-16 {{ $block->getBlockCSSName() }}"
         style="background-size: cover">
        <h1 class="w-full text-center text-3xl lg:text-5xl pb-12" style="">{!! $block->title_translated !!}</h1>
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
                    <div class="w-1/2 flex flex-col">
                        @foreach($tab->items as $index => $item)
                            @if($item->fa_icon_classes != null)
                                <i class="fa {{ $item->fa_icon_classes }} mb-4"  style="width: 3rem; height: 3rem"></i>
                            @else
                                <img src="/storage/attachments/{{ basename($item->image_url) }}" class="h-16">
                            @endif
                            <h3 class="text-xl lg:text-3xl pb-1">{{ $item->title_translated }}</h3>
                            <div class="font-light tracking-normal mb-16">{!! $item->content_translated !!}</div>
                        @endforeach
                    </div>
                </div>
            @endpush
            @push('tabcontent-mobile-'.$block->id)
                <h4 class="text-2xl font-bold text-center py-8">{{ $tab->title_translated }}</h4>
                <div class="w-full flex flex-col items-start justify-start p-4 mb-4">
                    <img class="w-full object-contain" src="/storage/attachments/{{ basename($tab->image_url) }}">
                </div>
                <div class="w-full flex flex-col items-center">
                    @foreach($tab->items as $index => $item)
                        <img src="{{ $item->image_url }}" class="h-16">
                        <h3 class="text-xl font-bold lg:text-2xl">{{ $item->title_translated }}</h3>
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
</div>
