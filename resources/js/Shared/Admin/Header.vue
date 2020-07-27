<template>

    <div>
        <h1 class="mb-3 text-xl font-semibold text-gray-900 md:mb-8 md:text-3xl dark:text-white">
            <inertia-link
                    class="text-gray-500 hover:text-gray-600 hover:no-underline"
                    :href="href">
                {{ previousTitle }}
            </inertia-link>
            <span class="font-medium">
                /
            </span>
            <span>
                <slot></slot>
            </span>
        </h1>
    </div>


</template>

<script>
    export default {
        name: "Header",
        props: {
            href: String,
            previousTitle: String,
            title: String
        }
    }
</script>

<style scoped>

</style>