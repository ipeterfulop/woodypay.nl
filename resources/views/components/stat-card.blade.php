<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white"
                     stroke="currentColor"
                     fill="{{ $svgfill ?? 'none' }}"
                     viewBox="0 0 20 20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          @if(isset($fillrule)) fill-rule="{{ $fillrule }}" @endif
                          @if(isset($cliprule)) clip-rule="{{ $cliprule }}" @endif

                          d="{{ $iconPathDefinition }}"></path>
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                        {{ $label }}
                    </dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                            {{ $count }}
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <div class="text-sm leading-5">
            <a href="{{ $url }}"
               class="font-medium text-indigo-600 hover:text-indigo-500 transition ease-in-out duration-150">
                @lang('Megtekintés')
            </a>
        </div>
    </div>
</div>
