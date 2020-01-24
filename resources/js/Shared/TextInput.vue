<template>

    <div>

        <div v-if="label" class="flex flex-col">
            <label :for="id" class="block text-sm font-semibold mb-2 dark:text-white">{{ label + ':' }}</label>
            <input :id="id"
                   :value="value"
                   :placeholder="placeholder"
                   :type="type"
                   v-bind="$attrs"
                   @update="$emit('input', $event)"
                   @input="$emit('input', $event.target.value)"
                   ref="input"
                   class="shadow appearance-none border dark:border-gray-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark-focus:border-gray-500 dark-focus:shadow-none dark:bg-gray-600 dark:text-white" />
            <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
            <slot/>
        </div>

        <div v-else>
            <input :id="id"
                   :value="value"
                   :placeholder="placeholder"
                   :type="type"
                   v-bind="$attrs"
                   @update="$emit('input', $event)"
                   @input="$emit('input', $event.target.value)"
                   class="shadow appearance-none border dark:border-gray-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark-focus:border-gray-500 dark-focus:shadow-none dark:bg-gray-600 dark:text-white"
                   ref="input"/>
            <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
            <slot/>
        </div>

    </div>

</template>

<script>
    export default {
        name: "TextInput",
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                default() {
                    return `text-input-${this._uid}`
                },
            },
            type: {
                type: String,
                default: 'text',
            },
            value: String,
            label: String,
            placeholder: String,
            errors: {
                type: Array,
                default: () => [],
            },
            size: {
                type: String,
                default: () => 'md'
            }
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            },
            select() {
                this.$refs.input.select()
            },
            setSelectionRange(start, end) {
                this.$refs.input.setSelectionRange(start, end)
            },
        },
    }
</script>

<style scoped>

</style>