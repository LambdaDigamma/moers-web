<template>

    <inertia-link :href="href"
                  class="flex items-center px-2 py-2 text-base font-medium leading-6 transition duration-150 ease-in-out rounded-md group focus:outline-none"
                  @click="clickedLink"
                  :class="active ? 'bg-gray-900 focus:bg-gray-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'">
        <svg class="w-6 h-6 mr-4 transition duration-150 ease-in-out" stroke="currentColor" fill="none" viewBox="0 0 24 24"
             :class="active ? 'text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300' : 'text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300'">
            <slot>
            </slot>
        </svg>
        {{ title }}
    </inertia-link>

</template>

<script>
    export default {
        name: "MenuItemMobile",
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
        },
        methods: {
            clickedLink() {
                console.log("Test")
                this.$emit('nav')
            }
        }
    }
</script>

<style scoped>

</style>