@if(count($submenuitems) == 0)
    <a href="{{ $url }}"
       class="group flex items-center px-2 py-2 text-sm leading-5 text-white focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150 @if($active) bg-gray-700 font-bold @else bg-gray-800 font-medium  @endif"
    >
        @if($heroiconConfigPath != null)
            {!! config($heroiconConfigPath) !!}
        @endif
        <span>{{ $label }}</span>
    </a>
@else
    <div x-data="{ isExpanded: {{ $active ? 'true' : 'false' }} }">
        <button class="w-full group flex items-center px-2 py-2 text-sm leading-5 font-medium text-white bg-gray-800 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150 flex justify-between" @click.prevent="isExpanded = !isExpanded" x-bind:aria-expanded="isExpanded">
            {{ $label }}
            <svg :class="{ 'text-gray-400 rotate-90': isExpanded, 'text-gray-300': !isExpanded }" x-state:on="Expanded" x-state:off="Collapsed" class="h-5 w-5 transform group-hover:text-gray-400 group-focus:text-gray-400 transition-colors ease-in-out duration-150 text-gray-300" viewBox="0 0 20 20">
                <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
            </svg>
        </button>
        <div x-show="isExpanded" x-description="Expandable link section, show/hide based on state." class="mt-1 space-y-1 pl-4" style="display: none;">
            @foreach($submenuitems as $index => $submenuitem)
                @include('tailwindui.layouts.admin-left-menu.partials.menuitem', [
                        'url' => $submenuitem->link,
                        'label' => $submenuitem->label,
                        'active' => $submenuitem->active,
                        'heroicon-config-path' => $submenuitem->heroiconConfigPath,
                        'submenuitems' => []
                    ])
            @endforeach
        </div>
    </div>
@endif
