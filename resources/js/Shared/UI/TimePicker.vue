<template>

    <div :class="{ 'opacity-50' : disabled }">

        <div class="flex" :class="{ 'justify-between' : isOptional, 'justify-start' : !isOptional }">
            <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional">Optional</span>
        </div>



    </div>

</template>

<script>
    export default {
        name: "TimePicker",
        props: {
            id: {
                type: String,
                default() {
                    return `time-input-${this._uid}`
                },
            },
            isOptional: {
                type: Boolean,
                default: false
            },
            label: String,
            placeholder: String,
            disabled: {
                type: Boolean,
                default: false
            },
        },
    }
</script>

<style scoped>

</style>