<template>

    <header class="py-10">
        <div class="mt-2 md:flex md:items-start md:justify-between">
            <div class="flex-1">
                <h2 v-if="!hasHeaderSlot" class="text-2xl font-bold leading-7 sm:text-3xl sm:leading-9 sm:truncate">
                    {{ title }}
                </h2>
                <slot v-else name="header"></slot>
            </div>
            <div class="mt-4 flex-shrink-0 flex md:mt-0 md:ml-4">
                <slot name="default"></slot>
            </div>
        </div>
        <div>
            <slot name="nav"></slot>
        </div>
    </header>

</template>

<script>
    export default {
        name: "Header",
        props: {
            title: {
                type: String,
                default: () => ''
            }
        },
        computed: {
            hasHeaderSlot() {
                return !!this.$slots.header
            },
        }
    }
</script>

<style scoped>

</style>
