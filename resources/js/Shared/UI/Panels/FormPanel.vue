<template>

    <div class="shadow rounded-lg bg-white">
        <form action="#" :method="method">
            <div class="px-4 py-5 sm:p-6">
                <slot></slot>
            </div>
            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6 rounded-b-lg">
                <PrimaryButton type="submit" @click.prevent="$emit('save')">{{ actionButton }}</PrimaryButton>
            </div>
        </form>
    </div>

</template>

<script>

    import PrimaryButton from "../PrimaryButton.vue";
    export default {
        name: "FormPanel",
        components: {PrimaryButton},
        props: {
            actionButton: {
                type: String,
                default: () => 'Speichern'
            },
            method: {
                type: String,
                default: () => 'POST'
            }
        }
    }
</script>

<style scoped>

</style>
