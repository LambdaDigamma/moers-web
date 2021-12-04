<template>
    <div>
        <div
            class="flex"
            :class="{
                'justify-between': isOptional,
                'justify-start': !isOptional,
            }"
        >
            <label
                :for="id"
                class="block text-sm font-medium leading-5 text-gray-700"
                >{{ label }}</label
            >
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional"
                >Optional</span
            >
        </div>
        <div class="relative rounded-md shadow-sm">
            <textarea
                :id="id"
                :rows="rows"
                :value="value"
                :placeholder="placeholder"
                :class="{ 'whitespace-pre': noWrap }"
                v-bind="$attrs"
                class="block w-full mt-1 transition duration-150 ease-in-out form-textarea sm:text-sm sm:leading-5"
                ref="input"
                @input="$emit('input', $event.target.value)"
            ></textarea>
            <div
                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"
                v-if="errors.length"
            >
                <svg
                    class="w-5 h-5 text-red-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"
                    />
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
                return `textarea-input-${this._uid}`;
            },
        },
        value: String,
        label: String,
        rows: {
            type: Number,
            default: 3,
        },
        placeholder: {
            type: String,
            default: "",
        },
        hint: {
            type: String,
            default: null,
        },
        isOptional: {
            type: Boolean,
            default: false,
        },
        errors: {
            type: Array,
            default: () => [],
        },
        noWrap: {
            type: Boolean,
            default: () => false,
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
    },
};
</script>
