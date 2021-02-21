<template>

    <div @keydown.esc="open = false" class="relative inline-block text-left" v-click-outside="closeDropdown">
        <div>
            <button @click="open = !open" class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring">
                <span class="inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-200 rounded-full">
                    {{ findLanguage(currentLanguageCode).flag }}
                </span>
            </button>
        </div>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95">

            <div v-show="open"
                 class="transform origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg z-20">
                <div class="rounded-md bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <inertia-link :href="route('language', [languages[index].value])"
                             v-for="(language, index) in languages"
                             :key="index"
                             @click="closeDropdown"
                             class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition duration-100"
                             :class="[ language.value === currentLanguageCode ? 'bg-gray-200 hover:bg-gray-300' : 'hover:bg-gray-100' ]">
                            {{ language.flag }}
                            <span class="ml-1">
                                {{ language.name }}
                            </span>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </transition>
    </div>

</template>

<script>
    import ClickOutside from "vue-click-outside";

    export default {
        name: "LanguageBubble",
        data() {
            return {
                languages: [
                    {
                        flag: '🇩🇪',
                        name: 'Deutsch',
                        value: 'de'
                    },
                    {
                        flag: '🇬🇧',
                        name: 'Englisch',
                        value: 'en'
                    }
                ],
                open: false
            }
        },
        directives: {
            ClickOutside
        },
        methods: {
            closeDropdown() {
                this.open = false
            },
            findLanguage(languageCode) {
                return this.languages.filter(language => language.value === languageCode )[0]
            }
        },
        computed: {
            currentLanguageCode() {
                return this.$page.locale
            }
        }
    }
</script>

<style scoped>

</style>