<template>
    <div
        v-html="parsedMarkdown"
        class="tui-editor-contents dark:bg-gray-700"
    ></div>
</template>

<script>
import * as marked from "marked";

export default {
    name: "MarkdownPresentation",
    props: {
        block: {
            type: Object,
            required: true,
        },
    },
    computed: {
        parsedMarkdown() {
            marked.setOptions({
                breaks: true,
            });
            return marked(this.block.data.text);
        },
    },
};
</script>

<style scoped></style>
