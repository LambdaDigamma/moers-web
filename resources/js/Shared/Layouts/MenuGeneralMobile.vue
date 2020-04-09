<template>

    <div>

        <MenuItemMobile title="Übersicht"
                        :href="route('dashboard')"
                        :active="isUrl('dashboard')"
                        v-on:nav="navigated">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"/>
        </MenuItemMobile>

        <MenuItemMobile title="Helfen"
                        v-if="$page.menuEntries.help"
                        :href="route('help.index')"
                        :active="isUrl('help')"
                        v-on:nav="navigated">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </MenuItemMobile>

        <MenuItemMobile title="Veranstaltungen"
                        v-if="$page.menuEntries.events"
                        :href="route('events.index')"
                        :active="isUrl('events')"
                        v-on:nav="navigated">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </MenuItemMobile>

<!--        <MenuItemMobile title="Abstimmungen"-->
<!--                         :href="route('polls.index')"-->
<!--                         :active="isUrl('polls')"-->
<!--                         v-on:nav="navigated">-->
<!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />-->
<!--        </MenuItemMobile>-->

    </div>

</template>

<script>
    import MenuItemMobile from "./MenuItemMobile";
    export default {
        name: "MenuGeneralMobile",
        components: {MenuItemMobile},
        props: {
            url: String,
        },
        methods: {
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url === ''
                }

                return urls.filter(url => this.url.startsWith(url)).length !== 0
            },
            navigated() {
                this.$emit('navigated')
            }
        }
    }
</script>

<style scoped>

</style>