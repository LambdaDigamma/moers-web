<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex px-2 lg:px-0">
                <div class="flex items-center flex-shrink-0">
                    <a href="#">
                        <img class="w-auto h-8" src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg"
                            alt="Workflow">
                    </a>
                </div>
                <nav aria-label="Global" class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900">
                        Veranstaltungen
                    </a>

                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900">
                        Jobs
                    </a>

                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900">
                        Applicants
                    </a>

                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900">
                        Company
                    </a>
                </nav>
            </div>
            <div class="flex items-center justify-center flex-1 px-2 lg:ml-6 lg:justify-end">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Suchen</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <!-- Heroicon name: solid/search -->
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search" name="search"
                            class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                            placeholder="Suchen" type="search">
                    </div>
                </div>
            </div>
            <div class="flex items-center lg:hidden">
                <!-- Mobile menu button -->
                <button type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Heroicon name: outline/menu -->
                    <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile menu, show/hide based on mobile menu state. -->
            <div class="lg:hidden">
                <!--
                Mobile menu overlay, show/hide based on mobile menu state.
    
                Entering: "duration-150 ease-out"
                  From: "opacity-0"
                  To: "opacity-100"
                Leaving: "duration-150 ease-in"
                  From: "opacity-100"
                  To: "opacity-0"
              -->
                <div class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true"></div>

                <!--
                Mobile menu, show/hide based on mobile menu state.
    
                Entering: "duration-150 ease-out"
                  From: "opacity-0 scale-95"
                  To: "opacity-100 scale-100"
                Leaving: "duration-150 ease-in"
                  From: "opacity-100 scale-100"
                  To: "opacity-0 scale-95"
              -->
                <div class="absolute top-0 right-0 z-30 w-full p-2 transition origin-top transform max-w-none">
                    <div
                        class="bg-white divide-y divide-gray-200 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="pt-3 pb-2">
                            <div class="flex items-center justify-between px-4">
                                <div>
                                    <img class="w-auto h-8"
                                        src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg"
                                        alt="Workflow">
                                </div>
                                <div class="-mr-2">
                                    <button type="button"
                                        class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                        <span class="sr-only">Close menu</span>
                                        <!-- Heroicon name: outline/x -->
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-2 mt-3 space-y-1">
                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Veranstaltungen</a>

                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Jobs</a>

                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Applicants</a>

                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Company</a>
                            </div>
                        </div>
                        <div class="pt-4 pb-2">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80"
                                        alt="">
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800">Whitney Francis</div>
                                    <div class="text-sm font-medium text-gray-500">whitney@example.com</div>
                                </div>
                                <button
                                    class="flex-shrink-0 p-1 ml-auto text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <span class="sr-only">View notifications</span>
                                    <!-- Heroicon name: outline/bell -->
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </button>
                            </div>
                            <div class="px-2 mt-3 space-y-1">
                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Your
                                    Profile</a>

                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Settings</a>

                                <a href="#"
                                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Sign
                                    out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="hidden lg:ml-4 lg:flex lg:items-center">
                <button type="button"
                    class="flex-shrink-0 p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="sr-only">View notifications</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <!-- Profile dropdown -->
                <div class="relative flex-shrink-0 ml-4">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80"
                                alt="">
                        </button>
                    </div>

                    <!--
                  Dropdown menu, show/hide based on menu state.
    
                  Entering: "transition ease-out duration-100"
                    From: "transform opacity-0 scale-95"
                    To: "transform opacity-100 scale-100"
                  Leaving: "transition ease-in duration-75"
                    From: "transform opacity-100 scale-100"
                    To: "transform opacity-0 scale-95"
                -->
                    <div class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="user-menu-item-0">Your Profile</a>

                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="user-menu-item-1">Settings</a>

                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="user-menu-item-2">Sign out</a>
                            </div>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="px-4 mx-auto max-w-7xl sm:px-6">
        <div class="py-3 border-t border-gray-200">
            <nav class="flex" aria-label="Breadcrumb">
                <div class="flex sm:hidden">
                    <a href="#"
                        class="inline-flex space-x-3 text-sm font-medium text-gray-500 group hover:text-gray-700">
                        <!-- Heroicon name: solid/arrow-narrow-left -->
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-600"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Back to Applicants</span>
                    </a>
                </div>
                <div class="hidden sm:block">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                    <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <span class="sr-only">Home</span>
                                </a>
                            </div>
                        </li>
                        {{ $breadcrumbs }}
                    </ol>
                </div>
            </nav>
        </div>
    </div>
</header>