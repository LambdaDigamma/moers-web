<template>

    <div>
        <portal-target name="dropdown" slim />

        <div class="flex h-screen overflow-hidden bg-gray-100" @keydown.esc="hideSidebar" tabindex="0">
            <!-- Off-canvas menu for mobile -->
            <div class="md:hidden">
                <div @click="sidebarOpen = false" class="fixed inset-0 z-30 transition-opacity duration-300 ease-linear bg-gray-600 opacity-0 pointer-events-none" :class="{'opacity-75 pointer-events-auto': sidebarOpen, 'opacity-0 pointer-events-none': !sidebarOpen}"></div>
                <div class="fixed inset-y-0 left-0 z-40 flex flex-col w-full max-w-xs duration-300 ease-in-out transform bg-gray-800" :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
                    <div class="absolute top-0 right-0 p-1 -mr-14">
                        <button v-show="sidebarOpen" @click="sidebarOpen = false" class="flex items-center justify-center w-12 h-12 rounded-full focus:outline-none focus:bg-gray-600">
                            <svg class="w-6 h-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center flex-shrink-0 h-16 px-4 bg-gray-900">
                        <inertia-link :href="route('landingPage')" class="text-lg font-bold text-white">Mein Moers</inertia-link>
                    </div>
                    <div class="flex-1 h-0 overflow-y-auto">
                        <nav class="px-2 py-4">

<!--                            <MenuItemMobile title="Übersicht"-->
<!--                                            :href="route('dashboard')"-->
<!--                                            :active="isUrl('dashboard')"-->
<!--                                            v-on:nav="hideSidebar">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"/>-->
<!--                            </MenuItemMobile>-->

<!--                            <MenuItemMobile title="Helfen"-->
<!--                                             :href="route('help.index')"-->
<!--                                             :active="isUrl('help')"-->
<!--                                             v-on:nav="hideSidebar">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />-->
<!--                            </MenuItemMobile>-->

<!--                            <MenuItemMobile title="Veranstaltungen"-->
<!--                                            href="#"-->
<!--                                            :active="isUrl('events')"-->
<!--                                            v-on:nav="hideSidebar">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>-->
<!--                            </MenuItemMobile>-->

<!--                            <MenuItemMobile title="Abstimmungen"-->
<!--                                             :href="route('polls.index')"-->
<!--                                             :active="isUrl('polls')"-->
<!--                                             v-on:nav="hideSidebar">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                            </MenuItemMobile>-->

                        </nav>
                    </div>
                </div>
            </div>

            <!-- Static sidebar for desktop -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex items-center flex-shrink-0 h-16 px-4 bg-gray-900">
                        <inertia-link :href="route('landingPage')" class="text-lg font-bold text-white">Mein Moers</inertia-link>
                    </div>
                    <div class="flex flex-col flex-1 h-0 overflow-y-auto">
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <nav class="flex-1 px-2 py-4 bg-gray-800">

<!--                            <MenuItemDesktop title="Übersicht"-->
<!--                                             :href="route('dashboard')"-->
<!--                                             :active="isUrl('dashboard')">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6" />-->
<!--                            </MenuItemDesktop>-->

<!--                            <MenuItemDesktop title="Helfen"-->
<!--                                             :href="route('help.index')"-->
<!--                                             :active="isUrl('help')">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />-->
<!--                            </MenuItemDesktop>-->

<!--                            <MenuItemDesktop title="Veranstaltungen"-->
<!--                                             :href="route('events.index')"-->
<!--                                             :active="isUrl('events')">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>-->
<!--                            </MenuItemDesktop>-->

<!--                            <MenuItemDesktop title="Abstimmungen"-->
<!--                                             :href="route('polls.index')"-->
<!--                                             :active="isUrl('polls')"-->
<!--                                             v-if="$page.auth.user">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--                            </MenuItemDesktop>-->

                        </nav>
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                <div class="relative z-10 flex flex-shrink-0 h-16 bg-white shadow-sm">
                    <button @click="sidebarOpen = true" class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <div class="flex justify-between flex-1 px-4">
                        <div class="flex flex-1">
<!--                            <div class="flex w-full md:ml-0">-->
<!--                                <label for="search_field" class="sr-only">Suchen</label>-->
<!--                                <div class="relative w-full text-gray-400 focus-within:text-gray-600">-->
<!--                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">-->
<!--                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">-->
<!--                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />-->
<!--                                        </svg>-->
<!--                                    </div>-->
<!--                                    <input id="search_field" class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 rounded-md focus:outline-none focus:placeholder-gray-400 sm:text-sm" placeholder="Suchen" />-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="flex items-center ml-4 md:ml-6" v-if="$page.auth.user">
                            <inertia-link :href="route('notifications')" class="relative p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500">
                                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span v-if="this.$page.auth.user.notifications_count !== 0" class="absolute bottom-0 right-0 block mb-1 mr-1 transform translate-x-1/2 translate-y-1/2 border-2 border-white rounded-full">
                                    <span class="block w-3 h-3 text-sm bg-red-600 rounded-full"></span>
                                </span>
                            </inertia-link>
                            <div class="relative ml-3">
                                <div>
                                    <button @click="open = !open" class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:shadow-outline"
                                            v-click-outside="hideDropdownMenus"
                                            @keydown.esc="hideDropdownMenus">
                                        <span class="inline-block w-8 h-8 overflow-hidden bg-gray-100 rounded-full">
                                            <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <transition
                                        enter-active-class="transition duration-100 ease-out"
                                        enter-class="transform scale-95 opacity-0"
                                        enter-to-class="transform scale-100 opacity-100"
                                        leave-active-class="transition duration-75 ease-in"
                                        leave-class="transform scale-100 opacity-100"
                                        leave-to-class="transform scale-95 opacity-0">
                                    <div v-show="open" class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg">
                                        <div class="py-1 bg-white rounded-md shadow-xs">
                                            <inertia-link :href="route('profile')"
                                                          class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100">
                                                Dein Profil
                                            </inertia-link>
                                            <inertia-link :href="route('logout')" method="POST"
                                                          class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100">
                                                Abmelden
                                            </inertia-link>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                        <div class="flex items-center ml-4 md:ml-6" v-else>
                            <inertia-link :href="route('login')" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500">
                                Anmelden
                            </inertia-link>
                        </div>
                    </div>
                </div>
                <main class="relative z-0 flex-1 py-6 overflow-y-auto focus:outline-none" tabindex="0" scroll-region>
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">

                        <flash-messages />
                        <slot />

                    </div>
                </main>

                <div class="fixed inset-x-0 bottom-0 pb-2 sm:pb-5" v-if="showBanner">
                    <div class="max-w-screen-xl px-2 mx-auto sm:px-6 lg:px-8">
                        <div class="p-2 bg-red-600 rounded-lg shadow-lg sm:p-3">
                            <div class="flex flex-wrap items-center justify-between">
                                <div class="flex items-center flex-1 w-0">
                                    <span class="flex p-2 bg-red-800 rounded-lg">
                                        <svg class="w-6 h-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </span>
                                    <p class="ml-3 font-medium text-white truncate">
                                        <span class="md:hidden">
                                            Hilf jetzt mit!
                                        </span>
                                                <span class="hidden md:inline">
                                            Hilf mit, die Krise gemeinsam zu bewältigen!
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 order-3 w-full mt-2 sm:order-2 sm:mt-0 sm:w-auto">
                                    <div class="rounded-md shadow-sm">
                                        <inertia-link :href="route('help.index')" class="flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-red-600 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-red-500 focus:outline-none focus:shadow-outline">
                                            Mehr erfahren
                                        </inertia-link>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 order-2 sm:order-3 sm:ml-2">
                                    <button type="button" class="flex p-2 -mr-1 transition duration-150 ease-in-out rounded-md hover:bg-red-500 focus:outline-none focus:bg-red-500" @click="hideBanner">
                                        <svg class="w-6 h-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer>
            <cookie-law theme="blood-orange" message="Diese Seite verwendet Session-Cookies und Cookies für das Login."
                        buttonText="Verstanden!"
                        buttonClass="rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150" />
        </footer>

    </div>

</template>

<script>
    import Dropdown from "@/Shared/Dropdown";
    import FlashMessages from "@/Shared/FlashMessages";
    import MainMenuGeneral from "@/Shared/MainMenuGeneral";
    import MenuItemDesktop from "./MenuItemDesktop";
    import MenuItemMobile from "./MenuItemMobile";
    import ClickOutside from 'vue-click-outside'
    import CookieLaw from 'vue-cookie-law'

    export default {
        name: "LayoutGeneral",
        components: {MenuItemMobile, MenuItemDesktop, MainMenuGeneral, Dropdown, FlashMessages, CookieLaw},
        data() {
            return {
                sidebarOpen: false,
                open: false,
                showBanner: true
            }
        },
        methods: {
            url() {
                return location.pathname.substr(1)
            },
            hideDropdownMenus() {
                this.open = false
            },
            hideSidebar() {
                this.sidebarOpen = false
            },
            hideBanner() {
                this.showBanner = false
                localStorage.setItem('showHelp', false)
            },
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url() === ''
                }

                return urls.filter(url => this.url().startsWith(url)).length !== 0
            },
        },
        directives: {
            ClickOutside
        },
        beforeMount() {
            if (localStorage.getItem('showHelp')) this.showBanner = JSON.parse(localStorage.getItem('showHelp'));
        },
        mounted() {

            if (this.$page.auth.user !== null) {

                Echo.private('App.User.' + this.$page.auth.user.id)
                    .notification((notification) => {
                        console.log(notification.type);
                        console.log('notification');
                        this.$page.auth.user.notifications_count += 1
                    });

            }

        }
    }
</script>

<style scoped>

</style>