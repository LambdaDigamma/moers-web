<template>
    <div>
        <label v-if="label" class="block text-sm font-semibold mb-2 dark:text-white">
          {{ label }}:
        </label>
        <div class="form-input p-0 dark:bg-gray-600" :class="{ error: errors.length }">
            <input ref="file" type="file" :accept="accept" class="hidden" @change="change">
            <div v-if="!value" class="p-2">
                <button type="button"
                        class="px-4 py-1 rounded-sm text-xs font-medium dark:text-white dark:bg-gray-800"
                        @click="browse">
                    Durchsuchen
                </button>
            </div>
            <div v-else class="flex items-center justify-between p-2 dark:text-white">
                <div class="flex-1 pr-1">{{ value.name }} <span class="text-xs">({{ filesize(value.size) }})</span>
                </div>
                <button type="button"
                        class="px-4 py-1 rounded-sm text-xs font-medium dark:text-white dark:bg-red-600"
                        @click="remove">
                    Entfernen
                </button>
            </div>
        </div>
        <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            value: File,
            label: String,
            accept: String,
            errors: {
                type: Array,
                default: () => [],
            },
        },
        watch: {
            value(value) {
                if (!value) {
                    this.$refs.file.value = ''
                }
            },
        },
        methods: {
            filesize(size) {
                var i = Math.floor(Math.log(size) / Math.log(1024))
                return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
            },
            browse() {
                this.$refs.file.click()
            },
            change(e) {
                this.$emit('input', e.target.files[0])
            },
            remove() {
                this.$emit('input', null)
            },
        },
    }
</script>
