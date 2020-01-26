<template>

    <div>
        <portal-target name="dropdown" slim />
        <div class="flex flex-col">
            <div class="md:h-screen flex flex-col" @click="hideDropdownMenus">
                <div class="md:flex">
                    <div class="bg-gray-900 md:flex-shrink-0 md:w-56 px-3 md:px-6 py-3 flex items-center justify-between md:justify-center">
                        <inertia-link class="mt-1 hover:no-underline" href="/">
                            <span class="dark:text-yellow-500 font-semibold">Mein Moers</span>
                        </inertia-link>
                        <dropdown class="md:hidden" placement="bottom-end">
                            <svg class="fill-white w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                            <div slot="dropdown" class="mt-2 px-8 py-4 shadow-lg bg-gray-600 dark:text-white rounded">
                                <MainMenuGeneral :url="url()" />
                            </div>
                        </dropdown>
                    </div>
                    <div class="dark:bg-gray-700 border-b border-yellow-500 w-full px-3 py-2 md:p-3 md:py-0 md:px-12 text-sm md:text-base flex justify-between md:justify-end items-center">
                        <h1 class="text-base font-semibold dark:text-white m-0 md:hidden">{{ title }}</h1>
                        <dropdown class="" placement="bottom-end">
                            <div class="flex items-center cursor-pointer select-none group">
                                <div class="font-medium dark:text-white group-hover:text-gray-600 focus:text-gray-600 mr-1 whitespace-no-wrap">
                                    <span class="hidden md:block">{{ $page.auth.user.name }}</span>
                                    <span class="block md:hidden">Du</span>
                                </div>
                                <icon class="w-5 h-5 dark-group-hover:fill-gray-600 fill-white focus:fill-gray-600" name="cheveron-down" />
                            </div>
                            <div slot="dropdown" class="mt-2 py-2 shadow-lg bg-white rounded text-sm">
<!--                                <inertia-link class="block px-6 py-2 hover:no-underline dark:text-gray-900 hover:bg-gray-700 dark-hover:text-white"-->
<!--                                              :href="route('landingPage', $page.auth.user.id)">-->
<!--                                    Mein Profil-->
<!--                                </inertia-link>-->
                                <inertia-link class="block px-6 py-2 hover:no-underline dark:text-gray-900 hover:bg-gray-700 dark-hover:text-white"
                                              method="post"
                                              :href="route('logout')">
                                    Abmelden
                                </inertia-link>
                            </div>
                        </dropdown>
                    </div>
                </div>
                <div class="flex flex-grow overflow-hidden">
                    <MainMenuGeneral :url="url()" class="bg-gray-900 flex-shrink-0 w-56 p-8 hidden md:block overflow-y-auto" />
                    <div class="w-full px-3 pt-3 md:pt-8 pb-0 md:p-12 md:pb-0 md:overflow-y-auto" scroll-region>
                        <flash-messages />
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Dropdown from "@/Shared/Dropdown";
    import FlashMessages from "@/Shared/FlashMessages";
    import MainMenuGeneral from "@/Shared/MainMenuGeneral";
    export default {
        name: "LayoutGeneral",
        components: {MainMenuGeneral, Dropdown, FlashMessages},
        data() {
            return {
                title: "",
                showUserMenu: false,
                accounts: null,
            }
        },
        methods: {
            url() {
                return location.pathname.substr(1)
            },
            hideDropdownMenus() {
                this.showUserMenu = false
            },
        },
        beforeMount() {
            this.$root.$on('newTitle', (newTitle) => {
                this.title = newTitle
            })
        }
    }
</script>

<style scoped>

</style>