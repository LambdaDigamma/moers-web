<template>

    <header class="bg-gray-900">
        <div class="flex px-2 py-3">
            <div class="flex sm:hidden">
                <button @click="toggle" type="button" class="px-2 text-gray-100 hover:text-white focus:outline-none focus:text-white">
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path v-if="isOpen" fill-rule="evenodd" clip-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
                        <path v-if="!isOpen" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center">
                <span class="text-base font-semibold dark:text-white">Mein Moers</span>
            </div>
        </div>
        <nav class="sm:flex sm" :class="{ 'hidden': !isOpen, 'flex': isOpen }">
            <div class="sm:flex sm:items-center sm:justify-center">
<!--                <div class="px-2 pt-2 pb-2 sm:flex">-->
<!--                    <a href="#" class="text-white no-underline dark-hover:bg-gray-700">Organisationen</a>-->
<!--                </div>-->

                <div v-if="$page.auth.user !== null">
                    {{ $page.auth.user.name }}
                </div>
<!--                <div class="px-2 pt-2 pb-5 border-b border-gray-800 sm:flex sm:border-b-0 sm:py-0 sm:px-0">-->
<!--                    <a href="#" class="block px-3 py-2 font-semibold text-white no-underline rounded hover:bg-gray-800 sm:text-sm sm:px-2 xl:text-gray-900 xl:hover:bg-gray-200">Produkte</a>-->
<!--&lt;!&ndash;                    <a :href="this.route('company')" class="block px-3 py-2 mt-1 font-semibold text-white rounded hover:bg-gray-800 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900 xl:hover:bg-gray-200">Unsere Philosophie</a>&ndash;&gt;-->
<!--                    <a href="#" class="block px-3 py-2 mt-1 font-semibold text-white no-underline rounded hover:bg-gray-800 sm:mt-0 sm:text-sm sm:px-2 sm:ml-2 xl:text-gray-900 xl:hover:bg-gray-200">Blog</a>-->
<!--                </div>-->
            </div>
        </nav>
    </header>

</template>

<script>
    export default {
        name: "Navigation",
        data() {
            return {
                isOpen: false,
            }
        },
        methods: {
            toggle() {
                this.isOpen = !this.isOpen
            },
        },
    }
</script>

<style scoped>

</style>