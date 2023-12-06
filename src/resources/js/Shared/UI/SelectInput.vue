<template>
    <div :class="{ 'opacity-50': disabled }">
        <label
            :for="id"
            v-if="label"
            class="block text-sm font-medium leading-5 text-gray-700"
        >
            {{ label }}
        </label>
        <select
            :id="id"
            ref="input"
            v-model="selected"
            v-bind="$attrs"
            :disabled="disabled"
            class="block w-full px-3 py-0 py-2 mt-1 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm form-select focus:outline-none focus:ring-blue focus:border-blue-300 sm:text-sm sm:leading-5"
        >
            <slot></slot>
        </select>
    </div>
</template>

<script>
export default {
    name: "SelectInput",
    props: {
        id: {
            type: String,
            default() {
                return `select-input-${this._uid}`;
            },
        },
        value: [String, Number, Boolean],
        label: {
            type: String,
            required: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        value: [String, Number, Boolean],
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
};
</script>

<style scoped></style>
