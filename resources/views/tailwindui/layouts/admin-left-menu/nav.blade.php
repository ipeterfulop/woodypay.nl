<!-- Off-canvas menu for mobile -->
<div x-show="sidebarOpen" class="md:hidden" style="display: none;">
    <div class="fixed inset-0 flex z-40">
        <div @click="sidebarOpen = false" x-show="sidebarOpen" x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state." x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0" style="display: none;">
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <div x-show="sidebarOpen" x-description="Off-canvas menu, show/hide based on off-canvas menu state." x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800" style="display: none;">
            <div class="absolute top-0 right-0 -mr-14 p-1">
                <button x-show="sidebarOpen" @click="sidebarOpen = false" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600" aria-label="Close sidebar" style="display: none;">
                    <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                @includeIf(config('tailwinduipackage.views.menuLogo'))
                <nav class="mt-5 px-2">
                    @foreach ($menuitems as $menuItem)
                        @include('tailwindui.layouts.admin-left-menu.partials.menuitem', [
                            'url' => $menuItem->link,
                            'label' => $menuItem->label,
                            'active' => $menuItem->active,
                            'heroiconConfigPath' => $menuItem->heroiconConfigPath,
                            'submenuitems' => $menuItem->menuitems
                        ])
                    @endforeach
                </nav>
            </div>
            <!--
                this will be included in the nav menus. The auth blade directive is probably helpful here.
                both the mobile and the desktop menus include this file, so use responsive css
              -->
            @includeIf('tailwindui.customizations.profile-menu')
        </div>
        <div class="flex-shrink-0 w-14">
            <!-- Force sidebar to shrink to fit close icon -->
        </div>
    </div>
</div>

<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-gray-800">
        <div class="h-0 flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
        @includeIf(config('tailwinduipackage.views.menuLogo'))
        <!-- Sidebar component, swap this element with another sidebar if you like -->
            <nav class="mt-5 flex-1 px-2 bg-gray-800">
                @foreach ($menuitems as $menuItem)
                    @include('tailwindui.layouts.admin-left-menu.partials.menuitem', [
                        'url' => $menuItem->link,
                        'label' => $menuItem->label,
                        'active' => $menuItem->active,
                        'heroiconConfigPath' => $menuItem->heroiconConfigPath,
                        'submenuitems' => $menuItem->menuitems
                    ])
                @endforeach
            </nav>
        </div>
        <!--
            this will be included in the nav menus. The auth blade directive is probably helpful here.
            both the mobile and the desktop menus include this file, so use responsive css
          -->
        @includeIf('tailwindui.customizations.profile-menu')
    </div>
</div>
