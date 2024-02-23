<template>
    <EditorPreset>
        <template v-slot:pre>
            <div
                class="flex items-center justify-center w-10 h-10 rounded-full dark:bg-yellow-500"
            >
                <Icon name="paragraph" class="w-8 h-8 fill-gray-900" />
            </div>
            <span class="mt-2 text-xs font-medium text-center">
                SoundCloud
            </span>
        </template>
        <template v-slot:default>
            <div class="flex flex-row items-end">
                <TextInput
                    v-model="url"
                    label="SoundCloud URL"
                    class="flex-grow-1"
                >
                </TextInput>
                <button
                    class="flex-grow-0 px-3 py-2 text-base font-semibold rounded-lg dark:bg-gray-800 dark:text-white"
                >
                    Überprüfen
                </button>
            </div>
            <div class="mt-3">
                <iframe
                    width="100%"
                    height="166"
                    scrolling="no"
                    frameborder="no"
                    allow="autoplay"
                    :src="musicSrc"
                >
                </iframe>
            </div>
        </template>
    </EditorPreset>
</template>

<script>
import TextInput from "../../UI/TextInput.vue";
import EditorPreset from "./EditorPreset.vue";

export default {
    name: "SoundCloudEditor",
    components: { EditorPreset, TextInput },
    computed: {
        musicSrc() {
            return (
                "https://w.soundcloud.com/player/?url=" +
                encodeURI(this.url) +
                "&amp;visual=true"
            );
        },
    },
    data() {
        return {
            url: "https://api.soundcloud.com/tracks/293",
        };
    },
};
</script>

<style scoped></style>
