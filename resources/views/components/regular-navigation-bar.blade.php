<header class="bg-white shadow" x-data="{ open: false }">
    <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500"
                    aria-controls="mobile-menu" @click="open = !open" aria-expanded="false"
                    x-bind:aria-expanded="open.toString()">
                    <span class="sr-only">Open main menu</span>
                    <svg x-description="Icon when menu is closed. Heroicon name: outline/menu" x-state:on="Menu open"
                        x-state:off="Menu closed" class="block w-6 h-6" :class="{ 'hidden': open, 'block': !(open) }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                    <svg x-description="Icon when menu is open. Heroicon name: outline/x" x-state:on="Menu open"
                        x-state:off="Menu closed" class="hidden w-6 h-6" :class="{ 'block': open, 'hidden': !(open) }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-between">
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 font-bold">
                        <img class="w-8 h-8 rounded-lg shadow-md md:h-10 md:w-10" src="/svg/mm.svg"
                            alt="Mein Moers Icon" aria-hidden="true" />
                        <span class="md:text-lg">Mein Moers</span>
                    </a>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <nav class="flex space-x-4" aria-label="Global">
                        <x-system.nav-icon route="events.index" title="Veranstaltungen">
                            <x-heroicon-o-calendar />
                        </x-system.nav-icon>
                        <x-system.nav-icon route="rubbish.index" title="Abfallkalender">
                            <x-heroicon-o-trash />
                            {{--
                            <x-hero-icon name="abfall-outline" /> --}}
                        </x-system.nav-icon>
                        <x-system.nav-icon route="parking-area.index" title="Parkplätze">
                            <x-hero-icon name="parking-outline" />
                        </x-system.nav-icon>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div x-description="Mobile menu, show/hide based on menu state." class="sm:hidden" id="mobile-menu" x-show="open"
        style="display: none;">
        <div class="pt-2 pb-4 space-y-1">
            <x-system.navigation-link route="home">
                Übersicht
            </x-system.navigation-link>
            <x-system.navigation-link route="rubbish.index">
                Abfallkalender
            </x-system.navigation-link>
            <x-system.navigation-link route="petrol.index">
                Tankstellen
            </x-system.navigation-link>
            <x-system.navigation-link route="parking-area.index">
                Parken
            </x-system.navigation-link>
        </div>
    </div>
    <div class="hidden px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 md:block">
        <div class="py-3 border-t border-gray-200">
            <nav class="flex" aria-label="Breadcrumb">
                <div class="flex sm:hidden">
                    <a href="#"
                        class="inline-flex space-x-3 text-sm font-medium text-gray-500 group hover:text-gray-700">
                        <!-- Heroicon name: solid/arrow-narrow-left -->
                        <x-heroicon-s-arrow-narrow-left
                            class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-600">
                        </x-heroicon-s-arrow-narrow-left>
                        <span>Back to Applicants</span>
                    </a>
                </div>
                <div class="hidden sm:block">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                    <x-heroicon-s-home class="flex-shrink-0 w-5 h-5" />
                                    <span class="sr-only">Home</span>
                                </a>
                            </div>
                        </li>
                        @if (isset($breadcrumbs))
                        {{ $breadcrumbs }}
                        @endif
                    </ol>
                </div>
            </nav>
        </div>
    </div>
</header>