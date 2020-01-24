<template>
    <div>
        <label v-if="label" class="block text-sm font-semibold mb-2 dark:text-white" :for="id">{{ label }}:</label>
        <textarea :id="id" ref="input" v-bind="$attrs" class="form-textarea shadow appearance-none border dark:border-gray-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark-focus:border-gray-500 dark-focus:shadow-none dark:bg-gray-600 dark:text-white"
                  :class="{ 'dark:border-red-600': errors.length }"
                  :value="value" @input="$emit('input', $event.target.value)" />
        <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
    </div>
</template>

<script>
    export default {
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                default() {
                    return `textarea-input-${this._uid}`
                },
            },
            value: String,
            label: String,
            errors: {
                type: Array,
                default: () => [],
            },
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            },
            select() {
                this.$refs.input.select()
            },
        },
    }
</script>
