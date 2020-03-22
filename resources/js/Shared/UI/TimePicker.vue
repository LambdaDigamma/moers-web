<template>

    <div :class="{ 'opacity-50' : disabled }">

        <div class="flex" :class="{ 'justify-between' : isOptional, 'justify-start' : !isOptional }">
            <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional">Optional</span>
        </div>

        <input type="time" name="hrs" placeholder="hrs:mins"
               :disabled="disabled"
               v-bind="$attrs"
               pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$"
               class="mt-1 form-input block w-full pr-10 sm:text-sm sm:leading-5"
               v-model="time"
               @update="$emit('input', $event)"
               @input="$emit('input', $event.target.value)"
               @keydown.enter.prevent="">

    </div>

</template>

<script>
    import TextInput from "../TextInput";
    import VueTimepicker from 'vue2-timepicker';

    export default {
        name: "TimePicker",
        inheritAttrs: false,
        components: {TextInput, VueTimepicker},
        props: {
            id: {
                type: String,
                default() {
                    return `time-input-${this._uid}`
                },
            },
            isOptional: {
                type: Boolean,
                default: false
            },
            label: String,
            placeholder: String,
            disabled: {
                type: Boolean,
                default: false
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
        data() {
            return {
                time: null
            }
        }
    }
</script>

<style>

</style>