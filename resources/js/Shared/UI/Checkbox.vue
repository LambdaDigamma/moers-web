<template>

    <div class="flex items-start" :class="{ 'opacity-50' : disabled }">
        <div class="flex items-center h-5">
            <input :id="id" type="checkbox"
                   ref="input"
                   v-model="checked" v-bind="$attrs"
                   class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" />
        </div>
        <div class="ml-2 text-sm leading-5">
            <label :for="id" class="font-medium text-gray-700">{{ label }}</label>
            <p class="text-gray-500" v-if="hint">
                {{ hint }}
            </p>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Checkbox",
        props: {
            id: {
                type: String,
                default() {
                    return `checkbox-${this._uid}`
                },
            },
            value: Boolean,
            label: String,
            hint: String,
            disabled: {
                type: Boolean,
                default: false
            },
        },
        inheritAttrs: false,
        data() {
            return {
                checked: this.value,
            }
        },
        watch: {
            checked(checked) {
                this.$emit('input', checked)
            },
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            },
            selected() {
                this.$refs.input.selected()
            },
        },
    }
</script>

<style scoped>

</style>