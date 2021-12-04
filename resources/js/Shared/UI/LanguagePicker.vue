<template>
    <div
        @keydown.esc="open = false"
        class="relative inline-block text-left"
        v-click-outside="closeDropdown"
    >
        <div>
            <span class="rounded-md shadow-sm">
                <button
                    @click="open = !open"
                    type="button"
                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800"
                >
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-4 h-4 mr-1"
                    >
                        <path
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Sprache: {{ findLanguage(currentLanguageCode).name }}
                    <svg
                        class="w-5 h-5 ml-2 -mr-1"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </span>
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
                        <div
                            v-for="(language, index) in languages"
                            @click="selectedLanguage(index)"
                            :key="index"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                            :class="[
                                language.value === currentLanguageCode
                                    ? 'bg-gray-200 hover:bg-gray-300'
                                    : 'hover:bg-gray-100',
                            ]"
                        >
                            {{ language.flag }}
                            <span class="ml-1">{{ language.name }}</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-100"></div>
                    <div class="py-1 opacity-50">
                        <a
                            href="#"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700"
                        >
                            Weitere hinzufügen
                        </a>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import Dropdown from "../Dropdown.vue";
import WhiteButton from "./WhiteButton.vue";
import ClickOutside from "vue-click-outside";

export default {
    name: "LanguagePicker",
    components: { WhiteButton, Dropdown },
    props: {
        languageCode: {
            type: String,
            default: "de",
        },
    },
    data() {
        return {
            currentLanguageCode: this.languageCode,
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
};
</script>

<style scoped></style>
