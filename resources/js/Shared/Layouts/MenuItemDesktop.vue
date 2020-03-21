<template>

    <inertia-link :href="href"
                  class="group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                  :class="active ? 'text-white bg-gray-900 focus:bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
        <svg class="mr-3 h-6 w-6 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150" stroke="currentColor" fill="none" viewBox="0 0 24 24"
             :class="active ? 'text-gray-300' : 'text-gray-400'">
            <slot></slot>
        </svg>
        {{ title }}
    </inertia-link>

</template>

<script>
    export default {
        name: "MenuItemDesktop",
        props: {
            title: {
                type: String
            },
            href: {
                type: String
            },
            active: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>