<template>

    <div :class="{ 'opacity-50' : disabled }">

        <div class="flex" :class="{ 'justify-between' : isOptional, 'justify-start' : !isOptional }">
            <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
            <span class="text-sm leading-5 text-gray-500" v-if="isOptional">Optional</span>
        </div>

        <vuejs-datepicker class="mt-1"
                          input-class="w-full form-input sm:text-sm sm:leading-5"
                          calendar-class="rounded-md"
                          wrapper-class="w-full"
                          format="D dd.MM.yyyy"
                          :full-month-name="true"
                          :language="de"
                          :placeholder="placeholder"
                          :disabled="disabled" />

    </div>

</template>

<script>
    import vuejsDatepicker from 'vuejs-datepicker';
    import {de} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DatePicker",
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
        },
        data() {
            return {
                de: de,
            }
        },
    }
</script>

<style scoped>

</style>