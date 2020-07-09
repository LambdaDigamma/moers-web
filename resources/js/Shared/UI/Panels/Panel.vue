<template>
    <div class="shadow rounded-lg bg-white">
        <slot v-if="hasHeadingSlot" name="heading"></slot>
        <div class="px-4 py-5 sm:p-6">
            <slot></slot>
        </div>
        <slot v-if="hasFooterSlot" name="footer"></slot>
    </div>
</template>

<script>
    export default {
        name: "Panel",
        computed: {
            hasHeadingSlot() {
                return !!this.$slots.heading
            },
            hasFooterSlot() {
                return !!this.$slots.footer
            }
        }
    }
</script>

<style scoped>

</style>