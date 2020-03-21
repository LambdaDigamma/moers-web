<template>

    <div>
        <div class="flex" :class="{ 'justify-between' : isOptional, 'justify-start' : !isOptional }">
            <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional">Optional</span>
        </div>
        <div class="relative rounded-md shadow-sm">
            <textarea :id="id"
                      :rows="rows"
                      :value="value"
                      :placeholder="placeholder"
                      v-bind="$attrs"
                      class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                      ref="input"
                      @input="$emit('input', $event.target.value)"
                      @keydown.enter.prevent="" />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" v-if="errors.length">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <p v-if="hint || errors.length" class="mt-2 text-sm text-gray-500">
            <span v-if="errors.length" class="text-red-600">
                {{ errors[0] }}
            </span>
            <span v-else-if="hint">
                {{ hint }}
            </span>
        </p>
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
            rows: {
                type: Number,
                default: 3
            },
            placeholder: {
                type: String,
                default: ''
            },
            hint: {
                type: String,
                default: null
            },
            isOptional: {
                type: Boolean,
                default: false
            },
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
