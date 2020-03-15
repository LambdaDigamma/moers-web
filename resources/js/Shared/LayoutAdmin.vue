<template>

    <div>
        <portal-target name="dropdown" slim />

        <div class="h-screen flex overflow-hidden bg-gray-100" @keydown.esc="sidebarOpen = false">
            <!-- Off-canvas menu for mobile -->
            <div class="md:hidden">
                <div @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-gray-600 opacity-0 pointer-events-none transition-opacity ease-linear duration-300" :class="{'opacity-75 pointer-events-auto': sidebarOpen, 'opacity-0 pointer-events-none': !sidebarOpen}"></div>
                <div class="fixed inset-y-0 left-0 flex flex-col z-40 max-w-xs w-full bg-gray-800 transform ease-in-out duration-300" :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
                    <div class="absolute top-0 right-0 -mr-14 p-1">
                        <button v-show="sidebarOpen" @click="sidebarOpen = false" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600">
                            <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-shrink-0 flex items-center h-16 px-4 bg-gray-900">
                        <span class="font-bold text-white text-lg">Mein Moers</span>
                    </div>
                    <div class="flex-1 h-0 overflow-y-auto">
                        <nav class="px-2 py-4">
                            <inertia-link :href="route('admin.dashboard')"
                                          class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/dashboard') ? 'bg-gray-900 focus:bg-gray-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-4 h-6 w-6 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                    :class="isUrl('admin/dashboard') ? 'text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300' : 'text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"/>
                                </svg>
                                Dashboard
                            </inertia-link>
                            <inertia-link :href="route('admin.organisations.index')"
                                          class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/organisations') ? 'bg-gray-900 focus:bg-gray-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-4 h-6 w-6 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/organisations') ? 'text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300' : 'text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Organisationen
                            </inertia-link>
                            <inertia-link href="#"
                                          class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                          :class="isUrl('admin/events') ? 'bg-gray-900 focus:bg-gray-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-4 h-6 w-6 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/events') ? 'text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300' : 'text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Veranstaltungen
                            </inertia-link>
                            <a :href="route('admin.pages.index')"
                               class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                               :class="isUrl('admin/pages') ? 'bg-gray-900 focus:bg-gray-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-4 h-6 w-6 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/pages') ? 'text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300' : 'text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Seiten
                            </a>
                            <inertia-link :href="route('admin.polls.index')"
                                          class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
                                          :class="isUrl('admin/polls') ? 'bg-gray-900 focus:bg-gray-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-4 h-6 w-6 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/polls') ? 'text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300' : 'text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Abstimmungen
                            </inertia-link>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Static sidebar for desktop -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                        <span class="font-bold text-white text-lg">Mein Moers</span>
                    </div>
                    <div class="h-0 flex-1 flex flex-col overflow-y-auto">
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <nav class="flex-1 px-2 py-4 bg-gray-800">
                            <inertia-link :href="route('admin.dashboard')"
                                          class="group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/dashboard') ? 'text-white bg-gray-900 focus:bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-3 h-6 w-6 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/dashboard') ? 'text-gray-300' : 'text-gray-400'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"/>
                                </svg>
                                Dashboard
                            </inertia-link>
                            <inertia-link :href="route('admin.organisations.index')"
                                          class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/organisations') ? 'text-white bg-gray-900 focus:bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-3 h-6 w-6 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/organisations') ? 'text-gray-300' : 'text-gray-400'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Organisationen
                            </inertia-link>
                            <inertia-link href="#"
                                          class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/events') ? 'text-white bg-gray-900 focus:bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-3 h-6 w-6 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/events') ? 'text-gray-300' : 'text-gray-400'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Veranstaltungen
                            </inertia-link>
                            <inertia-link :href="route('admin.polls.index')"
                                          class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/polls') ? 'text-white bg-gray-900 focus:bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-3 h-6 w-6 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/polls') ? 'text-gray-300' : 'text-gray-400'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Seiten
                            </inertia-link>
                            <inertia-link :href="route('admin.pages.index')"
                                          class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                          :class="isUrl('admin/pages') ? 'text-white bg-gray-900 focus:bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
                                <svg class="mr-3 h-6 w-6 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                                     :class="isUrl('admin/pages') ? 'text-gray-300' : 'text-gray-400'">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Abstimmungen
                            </inertia-link>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow-sm">
                    <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <div class="flex-1 px-4 flex justify-between">
                        <div class="flex-1 flex">
                            <div class="w-full flex md:ml-0">
                                <label for="search_field" class="sr-only">Suchen</label>
                                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                                        </svg>
                                    </div>
                                    <input id="search_field" class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm" placeholder="Suchen" />
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 flex items-center md:ml-6">
                            <inertia-link :href="route('notifications')" class="relative p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span v-if="$page.auth.user.notifications_count !== 0" class="absolute bottom-0 right-0 mb-1 mr-1 transform translate-y-1/2 translate-x-1/2 block border-2 border-white rounded-full">
                                    <span class="block h-3 w-3 rounded-full bg-red-600 text-sm"></span>
                                </span>
                            </inertia-link>
                            <div class="ml-3 relative"> <!--@click.away="open = false"-->
                                <div>
                                    <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline">
                                        <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <transition
                                        enter-active-class="transition ease-out duration-100"
                                        enter-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                    <div v-show="open" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                        <div class="py-1 rounded-md bg-white shadow-xs">
                                            <inertia-link :href="route('profile')"
                                                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">
                                                Dein Profil
                                            </inertia-link>
                                            <inertia-link :href="route('logout')" method="POST"
                                                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">
                                                Abmelden
                                            </inertia-link>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </div>
                <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0" scroll-region>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">

                        <flash-messages />
                        <slot />

                    </div>
                </main>
            </div>
        </div>


        <!--<div class="flex flex-col">
            <div class="h-screen flex flex-col" @click="hideDropdownMenus">
                <div class="md:flex">
                    <div class="bg-gray-900 md:flex-no-shrink md:w-56 px-6 py-3 flex items-center justify-between md:justify-center">
                        <inertia-link class="mt-1 hover:no-underline" href="/">
                            <span class="dark:text-yellow-500 font-semibold">Mein Moers</span>
                        </inertia-link>
                        <dropdown class="md:hidden" placement="bottom-end">
                            <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                            <div slot="dropdown" class="mt-2 px-8 py-4 shadow-lg bg-gray-600 dark:text-white rounded">
                                <main-menu :url="url()" />
                            </div>
                        </dropdown>
                    </div>
                    <div class="dark:bg-gray-700 border-b border-yellow-500 w-full p-3 md:py-0 md:px-12 text-sm md:text-base flex justify-end items-center">
                        <dropdown class="mt-1" placement="bottom-end">
                            <div class="flex items-center cursor-pointer select-none group">
                                <div class="dark:text-white group-hover:text-gray-600 focus:text-gray-600 mr-1 whitespace-no-wrap">
                                    <span>{{ $page.auth.user.name }}</span>
                                </div>
                                <icon class="w-5 h-5 dark-group-hover:fill-gray-600 fill-white focus:fill-gray-600" name="cheveron-down" />
                            </div>
                            <div slot="dropdown" class="mt-2 py-2 shadow-lg bg-white rounded text-sm">
                                <inertia-link class="block px-6 py-2 hover:no-underline dark:text-gray-900 hover:bg-gray-700 dark-hover:text-white"
                                              :href="route('landingPage', $page.auth.user.id)">
                                    Mein Profil
                                </inertia-link>
                            </div>
                        </dropdown>
                    </div>
                </div>
                <div class="flex flex-grow overflow-hidden">
                    <main-menu :url="url()" class="bg-gray-900 flex-no-shrink w-56 p-8 hidden md:block overflow-y-auto" />
                    <div class="w-full px-4 py-8 md:p-12 overflow-y-auto" scroll-region>
                        <flash-messages />
                        <slot />
                    </div>
                </div>
            </div>
        </div>-->
    </div>

</template>

<script>
    import Dropdown from "./Dropdown";
    import FlashMessages from "./FlashMessages";
    export default {
        name: "LayoutAdmin",
        components: {Dropdown, FlashMessages},
        data() {
            return {
                showUserMenu: false,
                accounts: null,
                sidebarOpen: false,
                open: false
            }
        },
        methods: {
            url() {
                return location.pathname.substr(1)
            },
            hideDropdownMenus() {
                this.showUserMenu = false
            },
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url() === ''
                }

                return urls.filter(url => this.url().startsWith(url)).length
            },
        },
    }
</script>

<style scoped>

</style>