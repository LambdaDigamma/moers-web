<template>
    <inertia-link
        :href="href"
        class="flex items-center px-2 py-2 text-sm font-medium leading-5 transition duration-150 ease-in-out rounded-md group focus:outline-none"
        :class="
            active
                ? 'text-white bg-gray-900 focus:bg-gray-700'
                : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700'
        "
    >
        <svg
            v-if="hasIcon"
            class="w-6 h-6 mr-3 transition duration-150 ease-in-out group-hover:text-gray-300 group-focus:text-gray-300"
            stroke="currentColor"
            fill="none"
            viewBox="0 0 24 24"
            :class="active ? 'text-gray-300' : 'text-gray-400'"
        >
            <slot></slot>
        </svg>
        <span :class="{ 'ml-1': !hasIcon }">{{ title }}</span>
    </inertia-link>
</template>

<script>
export default {
    name: "MenuItemDesktop",
    props: {
        title: {
            type: String,
        },
        href: {
            type: String,
        },
        active: {
            type: Boolean,
            default: false,
        },
        hasIcon: {
            type: Boolean,
            default: true,
        },
    },
};
</script>

<style scoped></style>
