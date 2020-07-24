<template>

    <div class="space-y-1">

        <MenuItemDesktop title="Übersicht"
                         :href="route('dashboard')"
                         :active="isUrl('dashboard')">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6" />
        </MenuItemDesktop>

        <MenuItemDesktop title="Veranstaltungen"
                         v-if="$page.menuEntries.events"
                         :href="route('events.index')"
                         :active="isUrl('events')">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </MenuItemDesktop>

        <MenuItemDesktop title="Karte"
                         v-if="$page.menuEntries.entries"
                         :href="route('entries.index')"
                         :active="isUrl('entries')">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </MenuItemDesktop>

        <MenuItemDesktop title="Helfen"
                         v-if="$page.menuEntries.help"
                         :href="route('help.index')"
                         :active="isUrl('help')">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </MenuItemDesktop>

<!--        <MenuItemDesktop title="Abstimmungen"-->
<!--                         :href="route('polls.index')"-->
<!--                         :active="isUrl('polls')"-->
<!--                         v-if="$page.auth.user">-->
<!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--        </MenuItemDesktop>-->

    </div>

</template>

<script>
    import MenuItemDesktop from "./MenuItemDesktop";
    export default {
        name: "MenuGeneralDesktop",
        components: {MenuItemDesktop},
        props: {
            url: String,
        },
        methods: {
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url === ''
                }
                return urls.filter(url => this.url.startsWith(url)).length !== 0
            }
        }
    }
</script>

<style scoped>

</style>