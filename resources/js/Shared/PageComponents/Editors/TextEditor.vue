<template>

    <EditorPreset>
        <template v-slot:pre>
            <div class="rounded-full w-10 h-10 flex items-center justify-center dark:bg-yellow-500">
                <Icon name="paragraph" class="h-8 w-8 fill-gray-900" />
            </div>
            <span class="mt-2 text-xs font-medium text-center">
                Text
            </span>
        </template>
        <template v-slot:default>
            <TextareaInput
                    v-model="block.data.text"
                    label="Text"
                    class="w-full" />
        </template>
    </EditorPreset>

</template>

<script>
    import Icon from "../../Icon";
    import TextareaInput from "../../TextareaInput";
    import EditorPreset from "./EditorPreset";
    export default {
        name: "TextEditor",
        components: {EditorPreset, TextareaInput, Icon},
        props: {
            block: {
                type: Object,
                required: false
            }
        }
    }
</script>

<style scoped>

</style>