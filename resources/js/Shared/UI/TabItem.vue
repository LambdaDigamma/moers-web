<template>

    <inertia-link :href="href"
                  class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm leading-5 focus:outline-none transition duration-150"
                  :class="active ?
                        'border-white text-white focus:text-red-100 focus:border-red-100' :
                        'border-transparent text-red-300 hover:text-white hover:border-white focus:text-white focus:border-white'"
                  :aria-current="active ? 'page' : ''">

        <div class="-ml-0.5 mr-2 h-5 w-5 transition duration-150">
            <svg class="fill-current transition duration-150" :class="active ? 'text-white group-focus:text-red-100' : 'text-red-300 hover:text-white group-hover:text-white group-focus:text-red-100'"
                 viewBox="0 0 20 20" fill="currentColor">
                <slot>
                </slot>
            </svg>
        </div>
        <span>
            {{ title }}
        </span>
    </inertia-link>

</template>

<script>
    export default {
        name: "TabItem",
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
            },
            hasIcon: {
                type: Boolean,
                default: true
            }
        }
    }
</script>

<style scoped>

</style>
