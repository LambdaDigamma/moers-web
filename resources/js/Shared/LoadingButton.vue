<template>

    <button :disabled="loading || disabled" class="flex items-center justify-center" :class="{ 'opacity-75 cursor-not-allowed': disabled }">
        <div v-if="loading" class="btn-spinner mr-2 text-black" />
        <slot />
    </button>

</template>

<script>
    export default {
        name: "LoadingButton",
        props: {
            loading: Boolean,
            disabled: Boolean
        }
    }
</script>

<style scoped>

</style>