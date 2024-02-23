<template>
    <div class="overflow-hidden bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-4 py-5 sm:p-6">
            <slot name="header" />
        </div>

        <!-- Container -->
        <div class="pb-4" :class="{ 'px-4 sm:px-6': insetContainer }">
            <slot />
        </div>

        <!-- Action Bar -->
        <div
            v-if="showActionBar"
            class="px-4 py-3 border-t rounded-b-lg dark:border-gray-600"
        >
            <slot name="actions" />
        </div>
    </div>
</template>

<script>
export default {
    name: "CardContainer",
    props: {
        insetContainer: {
            type: Boolean,
            default: () => true,
        },
        showActionBar: {
            type: Boolean,
            default: () => false,
        },
    },
};
</script>

<style scoped></style>
