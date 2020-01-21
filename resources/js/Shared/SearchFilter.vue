<template>
    <div class="flex items-center">
        <div class="flex bg-white dark:bg-gray-700 shadow rounded">
            <dropdown :auto-close="false"
                      class="px-4 md:px-6 rounded-l border-r dark:border-black dark-hover:bg-gray-600 focus:border-yellow-500 focus:shadow-outline focus:z-10"
                      placement="bottom-start">
                <div class="flex items-baseline">
                    <span class="hidden md:inline dark:text-gray-600">Filter</span>
                    <svg class="w-2 h-2 dark:fill-gray-600 md:ml-2" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 961.243 599.998">
                        <path d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z"/>
                    </svg>
                </div>
                <div slot="dropdown" class="mt-2 px-4 py-6 w-screen shadow-lg bg-white dark:bg-gray-600 rounded"
                     :style="{ maxWidth: `${maxWidth}px` }">
                    <slot/>
                </div>
            </dropdown>
            <input class="w-full px-2 py-2 md:px-2 md:py-3 rounded-r focus:shadow-outline dark:text-white dark:bg-gray-600"
                   autocomplete="off"
                   type="text"
                   name="search"
                   placeholder="Suche…"
                   :value="value"
                   @input="$emit('input', $event.target.value)">
        </div>
        <button class="ml-4 hidden md:flex text-sm text-gray-600 hover:text-gray-600 focus:text-yellow-500"
                type="button"
                @click="$emit('reset')">
            Zurücksetzen
        </button>
    </div>
</template>

<script>
    import Dropdown from '@/Shared/Dropdown'

    export default {
        components: {
            Dropdown,
        },
        props: {
            value: String,
            maxWidth: {
                type: Number,
                default: 300,
            },
        },
    }
</script>
