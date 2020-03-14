<template>

    <div>
        <div class="flex" :class="{ 'justify-between' : isOptional, 'justify-start' : !isOptional }">
            <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional">Optional</span>
        </div>
        <div class="mt-1 relative rounded-md shadow-sm">
            <input :id="id"
                   :value="value"
                   :placeholder="placeholder"
                   :type="type"
                   v-bind="$attrs"
                   :class="{ 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red' : this.hasError, 'focus:border-blue-500 focus:shadow-outline-blue' : !this.hasError }"
                   class="form-input block w-full pr-10 sm:text-sm sm:leading-5"
                   @update="$emit('input', $event)"
                   @input="$emit('input', $event.target.value)"
                   @keydown.enter.prevent=""
                   ref="input" />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" v-if="errors.length">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <p v-if="errors.length" class="mt-2 text-sm text-red-600">{{ errors[0] }}</p>
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
            isOptional: {
                type: Boolean,
                default: false
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
        computed: {
            hasError() {
                return this.errors.length !== 0
            }
        }
    }
</script>

<style scoped>

</style>