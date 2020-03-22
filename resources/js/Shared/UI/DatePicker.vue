<template>

    <div :class="{ 'opacity-50' : disabled }">

        <div class="flex justify-between">
            <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
            <div class="flex items-center text-gray-500">
                <span class="text-sm leading-5 text-gray-500" v-if="isOptional">Optional</span>
                <button @click.prevent="reset">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

        </div>

        <vuejs-datepicker class="mt-1"
                          ref="input"
                          input-class="w-full form-input sm:text-sm sm:leading-5"
                          calendar-class="rounded-md"
                          wrapper-class="w-full"
                          format="D dd.MM.yyyy"
                          v-bind="$attrs"
                          v-model="date"
                          :value="value"
                          :full-month-name="true"
                          :language="de"
                          :placeholder="placeholder"
                          :disabled="disabled"
                          @input="$emit('input', $event)" />

    </div>

</template>

<script>
    import vuejsDatepicker from 'vuejs-datepicker';
    import {de} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DatePicker",
        inheritAttrs: false,
        components: {vuejsDatepicker},
        props: {
            id: {
                type: String,
                default() {
                    return `date-input-${this._uid}`
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
            value: Date
        },
        data() {
            return {
                de: de,
                date: null,
            }
        },
        methods: {
            reset() {
                this.date = null
                this.$emit('input', null)
            }
        }
    }
</script>

<style scoped>

</style>