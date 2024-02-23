<template>
    <div
        @keydown.esc="open = false"
        class="relative inline-block text-left"
        v-click-outside="closeDropdown"
    >
        <div>
            <button
                @click="open = !open"
                class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring"
            >
                <span
                    class="inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-200 rounded-full"
                >
                    {{ findLanguage(currentLanguageCode).flag }}
                </span>
            </button>
        </div>
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <div
                v-show="open"
                class="absolute right-0 z-20 w-56 mt-2 origin-top-right transform rounded-md shadow-lg"
            >
                <div
                    class="bg-white rounded-md ring-1 ring-black ring-opacity-5"
                >
                    <div class="py-1">
                        <inertia-link
                            :href="route('language', [languages[index].value])"
                            v-for="(language, index) in languages"
                            :key="index"
                            @click="closeDropdown"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                            :class="[
                                language.value === currentLanguageCode
                                    ? 'bg-gray-200 hover:bg-gray-300'
                                    : 'hover:bg-gray-100',
                            ]"
                        >
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
                    flag: "🇩🇪",
                    name: "Deutsch",
                    value: "de",
                },
                {
                    flag: "🇬🇧",
                    name: "Englisch",
                    value: "en",
                },
            ],
            open: false,
        };
    },
    directives: {
        ClickOutside,
    },
    methods: {
        closeDropdown() {
            this.open = false;
        },
        findLanguage(languageCode) {
            return this.languages.filter(
                (language) => language.value === languageCode
            )[0];
        },
    },
    computed: {
        currentLanguageCode() {
            return this.$page.props.locale;
        },
    },
};
</script>

<style scoped></style>
