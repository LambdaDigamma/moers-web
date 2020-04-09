<template>

    <EditorPreset>
        <template v-slot:pre>
            <div class="flex items-center justify-center w-10 h-10 rounded-full dark:bg-yellow-500">
                <Icon name="externalLink" class="w-8 h-8 fill-gray-900" />
            </div>
            <span class="mt-2 text-xs font-medium text-center">
                Externer Link
            </span>
        </template>
        <template v-slot:default>
            <div class="flex flex-row items-end">
                <TextInput
                        v-model="url"
                        label="URL"
                        class="flex-grow-1">

                </TextInput>
                <button class="flex-grow-0 px-3 py-2 text-base font-semibold rounded-lg dark:bg-gray-800 dark:text-white">
                    Überprüfen
                </button>
            </div>
        </template>
    </EditorPreset>

</template>

<script>
    import EditorPreset from "./EditorPreset";
    export default {
        name: "ExternalLinkEditor",
        components: {EditorPreset},
        data() {
            return {
                url: ''
            }
        }
    }
</script>

<style scoped>

</style>