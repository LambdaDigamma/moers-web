<template>

    <FormPanel :action-button="actionButton" :method="method" @save="$emit('save')">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <slot name="description"></slot>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <slot></slot>
            </div>
        </div>
    </FormPanel>

</template>

<script>
    import FormPanel from "./FormPanel";
    export default {
        name: "FormColumnPanel",
        components: {FormPanel},
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