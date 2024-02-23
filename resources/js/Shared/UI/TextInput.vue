<template>
    <div>
        <div
            class="flex"
            :class="{
                'justify-between': isOptional,
                'justify-start': !isOptional,
            }"
            v-if="isOptional || label"
        >
            <label class="block text-sm font-medium leading-5 text-gray-700">
                {{ label }}
            </label>
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional">
                Optional
            </span>
        </div>
        <div class="relative mt-1 rounded-md shadow-sm">
            <input
                :placeholder="placeholder"
                :type="type"
                :disabled="disabled"
                :value="value"
                v-bind="$attrs"
                :class="{
                    'border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red':
                        this.hasError,
                    'opacity-50': disabled,
                    'focus:ring-blue-500 focus:border-blue-500':
                        !this.hasError,
                }"
                class="block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                @input="$emit('input', $event.target.value)"
                @keydown.enter.prevent=""
                ref="input"
            />
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
        <p v-if="hint || errors.length" class="mt-1 text-sm text-gray-500">
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
    name: "TextInput",
    inheritAttrs: false,
    props: {
        isOptional: {
            type: Boolean,
            default: false,
        },
        type: {
            type: String,
            default: "text",
        },
        value: [String, Number],
        label: String,
        placeholder: String,
        errors: {
            type: Array,
            default: () => [],
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        hint: {
            type: String,
            default: null,
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
    },
    computed: {
        hasError() {
            return this.errors.length !== 0;
        },
    },
};
</script>

<style scoped></style>
