<template>

    <div>

        <div v-if="label" class="flex flex-col">
            <label :for="id" class="block mb-2 text-sm font-semibold dark:text-white">{{ label + ':' }}</label>
            <input :id="id"
                   :value="value"
                   :placeholder="placeholder"
                   :type="type"
                   :min="min"
                   v-bind="$attrs"
                   @update="$emit('input', $event)"
                   @input="$emit('input', $event.target.value)"
                   ref="input"
                   class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none dark:border-gray-700 focus:outline-none focus:shadow-outline dark-focus:border-gray-500 dark-focus:shadow-none dark:bg-gray-600 dark:text-white" />
            <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
            <slot/>
        </div>

        <div v-else>
            <input :id="id"
                   :value="value"
                   :placeholder="placeholder"
                   :type="type"
                   :min="min"
                   v-bind="$attrs"
                   @update="$emit('input', $event)"
                   @input="$emit('input', $event.target.value)"
                   class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none dark:border-gray-700 focus:outline-none focus:shadow-outline dark-focus:border-gray-500 dark-focus:shadow-none dark:bg-gray-600 dark:text-white"
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
                    return `number-input-${this._uid}`
                },
            },
            type: {
                type: String,
                default: 'number',
            },
            min: {
                type: Number,
                default: 0
            },
            max: {
                type: Number,
                default: null
            },
            value: Number,
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