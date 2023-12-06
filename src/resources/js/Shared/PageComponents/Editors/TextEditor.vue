<template>
    <EditorPreset>
        <template v-slot:pre> </template>
        <template v-slot:default>
            <!-- <Editor
                mode="markdown"
                :options="editorOptions"
                v-model="block.data.text"
                preview-style="vertical"
                class="w-full"
            >
            </Editor> -->
            <!--            <TextareaInput-->
            <!--                    v-model="block.data.text"-->
            <!--                    label="Text"-->
            <!--                    class="w-full" />-->
        </template>
    </EditorPreset>
</template>

<script>
import Icon from "../../Icon.vue";
import TextareaInput from "../../UI/TextareaInput.vue";
import EditorPreset from "./EditorPreset.vue";
// import Editor from "@toast-ui/vue-editor/src/Editor.vue";
// import '@toast-ui/vue-editor/dist/'
// import 'tui-editor/dist/tui-editor.css';
// import 'tui-editor/dist/tui-editor-contents.css';
// import 'codemirror/lib/codemirror.css';

export default {
    name: "TextEditor",
    components: { EditorPreset, TextareaInput, Icon, Editor },
    props: {
        block: {
            type: Object,
            required: false,
        },
    },
    data() {
        return {
            editorOptions: {
                hideModeSwitch: true,
                usageStatistics: false,
                language: "de_DE",
                toolbarItems: [
                    "heading",
                    "bold",
                    "italic",
                    "strike",
                    "divider",
                    "hr",
                    "quote",
                    "divider",
                    "ul",
                    "ol",
                    "task",
                    "indent",
                    "outdent",
                    "divider",
                    "table",
                    "link",
                    "divider",
                ],
            },
            editorVisible: true,
        };
    },
};
</script>

<style scoped></style>
