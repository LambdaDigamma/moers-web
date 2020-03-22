<template>

    <div class="">
        <label :for="id" class="block text-sm leading-5 font-medium text-gray-700">
            {{ label }}
        </label>
        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="text-center">
                <input ref="file" type="file" :accept="accept" class="hidden" @change="change">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="mt-1 text-sm text-gray-600">
                    <button type="button"
                            class="font-medium text-blue-600 hover:text-indigo-500 focus:outline-none focus:underline transition duration-150 ease-in-out" @click="browse">
                        Lade ein Foto hoch
                    </button>
                    oder per Drag & Drop
                </p>
                <p class="mt-1 text-xs text-gray-500">
                    PNG, JPG, GIF bis zu 10MB
                </p>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ImagePreviewInput",
        props: {
            value: File,
            id: {
                type: String,
                default() {
                    return `text-input-${this._uid}`
                },
            },
            label: String,
            accept: {
                type: String,
                default: 'image/*'
            }
        },
        watch: {
            value(value) {
                if (!value) {
                    this.$refs.file.value = ''
                }
            },
        },
        methods: {
            change() {

            },
            browse() {
                this.$refs.file.click()
            },
        },
        computed: {
            supportsUpload() {
                if (navigator.userAgent.match(/(Android (1.0|1.1|1.5|1.6|2.0|2.1))|(Windows Phone (OS 7|8.0))|(XBLWP)|(ZuneWP)|(w(eb)?OSBrowser)|(webOS)|(Kindle\/(1.0|2.0|2.5|3.0))/)) {
                    return false
                }
                const el = document.createElement('input')
                el.type = 'file'
                return !el.disabled
            },
            supportsPreview() {
                return window.FileReader && !!window.CanvasRenderingContext2D
            },
            supportsDragAndDrop() {
                const div = document.createElement('div')
                return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && !('ontouchstart' in window || navigator.msMaxTouchPoints)
            },
        }
    }
</script>

<style scoped>

</style>