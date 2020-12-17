<nav x-data="{ open: false }" @keydown.window.escape="open = false" class="bg-gray-800">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-start h-24">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @includeIf(config('tailwinduipackage.views.menuLogo'))
                </div>
                <div class="hidden md:block">
                    @foreach ($menuitems as $menuItem)
                        <x-menuitem
                            url="{{ $menuItem->link }}"
                            label="{{ $menuItem->label }}"
                            active="{{ $menuItem->active }}"
                            view="tailwindui.layouts.admin-top-menu.partials.menuitem"
                        ></x-menuitem>

                    @endforeach
                </div>
            </div>
            <div class="hidden md:block ml-auto">
                <div class="ml-4 flex items-center md:ml-6">
                    <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true" x-bind:aria-expanded="open">
                                <!--<img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />-->
                                <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center text-black text-xl-center">
                                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-8 h-8">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                        <!--
                            this will be included in the nav menus. The auth blade directive is probably helpful here.
                            both the mobile and the desktop menus include this file, so use responsive css
                          -->
                        @includeIf('tailwindui.customizations.profile-menu')
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white" x-bind:aria-label="open ? 'Close main menu' : 'Main menu'" x-bind:aria-expanded="open">
                    <svg class="h-full w-full" stroke="currentColor" fill="none" >
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 sm:px-3">
            @foreach ($menuitems as $menuitem)
                <x-menuitem
                    url="{{ $menuItem->link }}"
                    label="{{ $menuItem->label }}"
                    active="{{ $menuItem->active }}"
                    view="tailwindui.layouts.admin-top-menu.partials.menuitem-mobile"
                ></x-menuitem>

            @endforeach
        </div>
        <!--
            this will be included in the nav menus. The auth blade directive is probably helpful here.
            both the mobile and the desktop menus include this file, so use responsive css
          -->
        @includeIf('tailwindui.customizations.profile-menu')
    </div>
</nav>
