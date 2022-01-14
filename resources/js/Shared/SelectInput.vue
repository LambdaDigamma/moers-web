<template>
    <div>
        <label
            v-if="label"
            class="block text-sm font-medium text-gray-700 dark:text-white"
            :for="id"
        >
            {{ label }}:
        </label>
        <select
            :id="id"
            ref="input"
            v-model="selected"
            v-bind="$attrs"
            class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none sm:text-sm"
            :class="{
                error: errors.length,
                'focus:ring-blue-500 focus:border-blue-500': !hasError,
            }"
        >
            <slot />
        </select>
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
                return undefined;
            },
        },
        value: [String, Number, Boolean],
        label: String,
        errors: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            selected: this.value,
        };
    },
    watch: {
        selected(selected) {
            this.$emit("input", selected);
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
    computed: {
        hasError() {
            return this.errors.length !== 0;
        },
    },
};
</script>
