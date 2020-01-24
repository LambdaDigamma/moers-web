<template>

    <div>
        <h1 class="mb-3 md:mb-8 font-bold text-xl md:text-3xl dark:text-white">
            <inertia-link
                    class="dark:text-yellow-500 dark-hover:text-yellow-600 hover:no-underline"
                    :href="href">
                {{ previousTitle }}
            </inertia-link>
            <span class="font-medium dark:text-yellow-500">
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