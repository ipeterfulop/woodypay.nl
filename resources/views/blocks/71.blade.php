<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>

<div class="w-full max-width-container flex items-start justify-center" x-data="{'currentTab': 0}">
    <div class="flex flex-col items-start justify-start py-16 px-4 {{ $block->getBlockCSSName() }}" style="background-size: cover">
<h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
<div class="w-full text-center px-3 py-3" style="">{!! $block->content !!}</div>
@foreach($block->getLists() as $tabIndex => $tab)
    @push('tabs-'.$block->id)
        <div class="cursor-pointer p-6 w-1/{{ count($block->lists) }}"
             data-tab-id="{{ $tabIndex }}"
             @click="currentTab = {{ $tabIndex }}"
             x-bind:class="{'active-tab': currentTab == {{ $tabIndex }}, 'inactive-tab': currentTab != {{ $tabIndex }}}"
        >{{ $tab->title }}</div>
    @endpush
    @push('tabcontent-'.$block->id)
        <div class="w-full flex flex-row items-start justify-between p-4"
             x-show="currentTab == {{ $tabIndex }}"
             x-bind:class="{'active-tab-content': currentTab == {{ $tabIndex }}}"
        >
            <div class="w-1/2 flex flex-col">
                @foreach($tab->items as $index => $item)
                    <img src="{{ $item->image_url }}" class="h-16">
                    <h3>{{ $item->title }}</h3>
                    <div>{!! $item->content !!}</div>
                @endforeach
            </div>
        </div>
    @endpush
    @push('tabcontent-mobile-'.$block->id)
        <div class="w-full flex flex-col items-start justify-start p-4 mb-4">
            <img class="w-full object-contain" src="{{ $tab->image_url }}">
        </div>
        <div class="w-full flex flex-col">
            @foreach($tab->items as $index => $item)
                <img src="{{ $item->image_url }}" class="h-16">
                <h3>{{ $item->title }}</h3>
                <div>{!! $item->content !!}</div>
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
