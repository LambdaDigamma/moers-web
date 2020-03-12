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
            <Editor mode="markdown"
                    :options="editorOptions"
                    v-model="block.data.text"
                    preview-style="vertical">

            </Editor>
<!--            <TextareaInput-->
<!--                    v-model="block.data.text"-->
<!--                    label="Text"-->
<!--                    class="w-full" />-->
        </template>
    </EditorPreset>

</template>

<script>
    import Icon from "../../Icon";
    import TextareaInput from "../../TextareaInput";
    import EditorPreset from "./EditorPreset";
    import Editor from '@toast-ui/vue-editor/src/Editor.vue'
    import 'tui-editor/dist/tui-editor.css';
    import 'tui-editor/dist/tui-editor-contents.css';
    import 'codemirror/lib/codemirror.css';

    export default {
        name: "TextEditor",
        components: {EditorPreset, TextareaInput, Icon, Editor},
        props: {
            block: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                editorOptions: {
                    hideModeSwitch: true,
                    usageStatistics: false,
                    language: 'de_DE',
                    toolbarItems: [
                        'heading',
                        'bold',
                        'italic',
                        'strike',
                        'divider',
                        'hr',
                        'quote',
                        'divider',
                        'ul',
                        'ol',
                        'task',
                        'indent',
                        'outdent',
                        'divider',
                        'table',
                        'link',
                        'divider',
                    ]
                },
                editorVisible: true,
            };
        },
    }
</script>

<style scoped>

</style>