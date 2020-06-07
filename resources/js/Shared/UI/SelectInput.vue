<template>

    <div :class="{ 'opacity-50' : disabled }">
        <label :for="id" v-if="label" class="block text-sm font-medium leading-5 text-gray-700">
            {{ label }}
        </label>
        <select :id="id"
                ref="input"
                v-model="selected"
                v-bind="$attrs"
                :disabled="disabled"
                class="mt-1 block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
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
                    return `select-input-${this._uid}`
                },
            },
            label: {
                type: String,
                required: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
            value: [String, Number, Boolean],
        },
        data() {
            return {
                selected: this.value,
            }
        },
        watch: {
            selected(selected) {
                this.$emit('input', selected)
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

<style scoped>

</style>