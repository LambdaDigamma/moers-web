<template>

    <div class="flex flex-wrap">
        <template v-for="(link, key) in links">
            <button v-if="link.url === null" :key="key" class="mr-3 mb-2 text-sm sm:text-base dark:text-gray-600" :class="{ 'ml-auto': link.label === 'Nächste' }" :disabled="true">
                {{ link.label }}
            </button>
            <button v-else
                      class="btn mr-3 mb-2"
                      :key="key"
                      :class="{ 'dark:bg-yellow-500': link.active, 'dark:bg-gray-700 dark:text-gray-200' : !link.active, 'ml-auto': link.label === 'Nächste' }"
                      @click="selectedButton(link.url)">
                {{ link.label }}
            </button>
        </template>
    </div>

</template>

<script>
    export default {
        name: "Pagination",
        props: {
            links: Array
        },
        methods: {
            selectedButton(url) {
                this.$inertia.visit(url)
            }
        }
    }
</script>

<style scoped>

</style>