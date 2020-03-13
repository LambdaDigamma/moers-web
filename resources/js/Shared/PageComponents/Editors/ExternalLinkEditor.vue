<template>

    <EditorPreset>
        <template v-slot:pre>
            <div class="rounded-full w-10 h-10 flex items-center justify-center dark:bg-yellow-500">
                <Icon name="externalLink" class="h-8 w-8 fill-gray-900" />
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
                <button class="flex-grow-0 px-3 py-2 rounded-lg font-semibold text-base dark:bg-gray-800 dark:text-white">
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