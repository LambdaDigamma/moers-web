<template>
    <div>
        <div class="grid grid-cols-7 gap-6">
            <div class="col-span-5">
                <draggable
                    tag="ul"
                    ghost-class="moving-card"
                    filter=".action-button"
                    class="w-full"
                    :list="blocks"
                    :animation="200"
                >
                    <div
                        v-for="(block, index) in blocks"
                        :key="index"
                        class="flex flex-row items-center mb-6 dark:text-white"
                    >
                        <TextEditor
                            v-if="block.type === 'markdown'"
                            :block="block"
                            @duplicated="duplicateBlock(index)"
                            @deleted="deleteBlock(index)"
                        />
                        <SoundCloudEditor
                            v-else-if="block.type === 'soundcloud'"
                            @duplicated="duplicateBlock(index)"
                            @deleted="deleteBlock(index)"
                        />

                        <ExternalLinkEditor
                            v-else-if="block.type === 'externalLink'"
                            :block="block"
                            @duplicated="duplicateBlock(index)"
                            @deleted="deleteBlock(index)"
                        />

                        <div
                            v-else
                            class="flex flex-row items-center justify-center w-full py-3 dark:text-white"
                        >
                            Dieser Baustein wird leider noch nicht unterstützt.
                        </div>
                    </div>
                    <div
                        v-if="blocks.length === 0"
                        class="flex flex-row items-center justify-center py-3 text-sm text-gray-600 dark:text-white"
                    >
                        Ziehe die gewünschten Inhalte aus dem Kasten rechts in
                        die Bearbeitungsfläche.
                    </div>
                </draggable>

                <div class="flex items-center mt-4 space-x-3">
                    <div class="flex-grow h-0.5 bg-gray-300"></div>

                    <button class="flex-grow-0 w-6 h-6">
                        <svg
                            class="text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>

                    <div class="flex-grow h-0.5 bg-gray-300"></div>
                </div>
            </div>
            <div class="col-span-2">
                <Panel>
                    <div>
                        <label
                            for="title"
                            class="block text-sm font-medium leading-5 text-gray-700"
                        >
                            Titel
                        </label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input
                                id="title"
                                class="block w-full form-input sm:text-sm sm:leading-5"
                                placeholder="Titel"
                                v-model="page.title"
                            />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label
                            for="slug"
                            class="block text-sm font-medium leading-5 text-gray-700"
                        >
                            Slug
                        </label>
                        <div class="flex mt-1 rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 sm:text-sm"
                            >
                                /
                            </span>
                            <input
                                id="slug"
                                placeholder="Slug"
                                v-model="page.slug"
                                class="flex-1 block w-full min-w-0 transition duration-150 ease-in-out rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
                            />
                        </div>
                        <p
                            class="mt-2 text-sm text-gray-500"
                            id="email-description"
                        >
                            Unter dieser Adresse wird die Seite erreichbar sein.
                        </p>
                    </div>

                    <PrimaryButton class="mt-4" @click="save" size="lg" block>
                        Speichern
                    </PrimaryButton>
                </Panel>
            </div>
        </div>

        <!--        <div class="flex flex-row mt-12">-->
        <!--            <div class="lg:w-3/4">-->
        <!--                <CardContainer class="lg:mr-2" :show-action-bar="false">-->
        <!--                    <template v-slot:header>-->
        <!--                        <h3 class="text-lg font-medium leading-6 text-gray-900">-->
        <!--                            {{ title }}-->
        <!--                        </h3>-->
        <!--                        <p class="mt-1 text-sm leading-5 text-gray-500">-->
        <!--                            Editiere die Details, die für diese Veranstaltung angezeigt werden-->
        <!--                        </p>-->
        <!--                    </template>-->
        <!--                    <div class="rounded-lg" :class="{ 'border dark:border-gray-600' : blocks.length === 0 }">-->
        <!--                        <div>-->
        <!--                            <draggable-->
        <!--                              :list="blocks"-->
        <!--                              group="blocks"-->
        <!--                              @change="updateOrder">-->
        <!--                                <div v-for="(block, index) in blocks"-->
        <!--                                     :key="index"-->
        <!--                                     class="flex flex-row items-center dark:text-white">-->

        <!--                                    <TextEditor-->
        <!--                                      v-if="block.type === 'markdown'"-->
        <!--                                      :block="block"-->
        <!--                                      @duplicated="duplicateBlock(index)"-->
        <!--                                      @deleted="deleteBlock(index)" />-->
        <!--                                    <SoundCloudEditor-->
        <!--                                      v-else-if="block.type === 'soundcloud'"-->
        <!--                                      @duplicated="duplicateBlock(index)"-->
        <!--                                      @deleted="deleteBlock(index)" />-->

        <!--                                    <ExternalLinkEditor-->
        <!--                                      v-else-if="block.type === 'externalLink'"-->
        <!--                                      :block="block"-->
        <!--                                      @duplicated="duplicateBlock(index)"-->
        <!--                                      @deleted="deleteBlock(index)" />-->

        <!--                                    <div v-else class="flex flex-row items-center justify-center w-full py-3 dark:text-white">-->
        <!--                                        Dieser Baustein wird leider noch nicht unterstützt.-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <div v-if="blocks.length === 0" class="flex flex-row items-center justify-center py-3 text-sm text-gray-600 dark:text-white">-->
        <!--                                    Ziehe die gewünschten Inhalte aus dem Kasten rechts in die Bearbeitungsfläche.-->
        <!--                                </div>-->
        <!--                            </draggable>-->
        <!--                        </div>-->

        <!--                    </div>-->
        <!--                </CardContainer>-->
        <!--            </div>-->
        <!--            <div class="lg:w-1/4">-->
        <!--                <CardContainer class="lg:ml-2" :inset-container="false">-->
        <!--                    &lt;!&ndash;                <input @keydown.enter.prevent=""&ndash;&gt;-->
        <!--                    &lt;!&ndash;                       v-model="query"&ndash;&gt;-->
        <!--                    &lt;!&ndash;                       placeholder="Suchen…"&ndash;&gt;-->
        <!--                    &lt;!&ndash;                       type="text"&ndash;&gt;-->
        <!--                    &lt;!&ndash;                       class="w-full px-2 py-2 rounded md:px-2 md:py-3 focus:ring dark:text-white dark:bg-gray-600" />&ndash;&gt;-->
        <!--                    <div class="px-3 pt-3 sm:px-6">-->
        <!--                        <draggable-->
        <!--                          :list="presets"-->
        <!--                          :group="{ name: 'blocks', pull: 'clone' }"-->
        <!--                          :clone="clone">-->
        <!--                            <div v-for="(preset, index) in presets"-->
        <!--                                 :key="index"-->
        <!--                                 class="flex flex-row items-center py-2 dark:text-white">-->
        <!--                                <Icon :name="preset.icon" class="w-10 h-10 mr-2 fill-current" />-->
        <!--                                <div>-->
        <!--                                    <h1 class="text-base font-semibold">{{ preset.name }}</h1>-->
        <!--                                    <p class="mb-0 text-sm font-normal">{{ preset.description }}</p>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </draggable>-->
        <!--                    </div>-->

        <!--                </CardContainer>-->
        <!--                <CardContainer class="mt-4 lg:ml-2">-->
        <!--                    <div class="flex flex-col">-->
        <!--                        <PrimaryButton @click="save" size="lg" block>-->
        <!--                            Speichern-->
        <!--                        </PrimaryButton>-->
        <!--                    </div>-->
        <!--                </CardContainer>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</template>

<script>
import draggable from "vuedraggable";
import CardContainer from "./UI/CardContainer.vue";
import Icon from "./Icon.vue";
import TextEditor from "./PageComponents/Editors/TextEditor.vue";
import SoundCloudEditor from "./PageComponents/Editors/SoundCloudEditor.vue";
import ExternalLinkEditor from "./PageComponents/Editors/ExternalLinkEditor.vue";
import PrimaryButton from "./UI/PrimaryButton.vue";
import Panel from "./UI/Panels/Panel.vue";

export default {
    name: "PageEditor",
    components: {
        Panel,
        PrimaryButton,
        ExternalLinkEditor,
        SoundCloudEditor,
        TextEditor,
        Icon,
        CardContainer,
        draggable,
    },
    props: {
        title: {
            type: String,
            default: () => "Beschreibungsseite",
        },
        page: {
            type: Object,
        },
        initialBlocks: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            query: null,
            page: this.page,
            blocks: this.sanitize(this.initialBlocks),
            presets: [
                {
                    type: "markdown",
                    name: "Text",
                    description: "Füge einen Textblock hinzu.",
                    icon: "paragraph",
                },
                {
                    type: "image",
                    name: "Bild",
                    description: "Füge ein Bild hinzu.",
                    icon: "image",
                },
                {
                    type: "soundcloud",
                    name: "Soundcloud Track",
                    description: "Füge einen Soundcloud Track hinzu.",
                    icon: "dashboard",
                },
            ],
        };
    },
    methods: {
        clone(obj) {
            return {
                type: obj.type,
                data: {},
            };
        },
        updateOrder() {
            _.forEach(this.blocks, function (block, i) {
                block.order = i;
            });
        },
        duplicateBlock(index) {
            const block = this.blocks[index];
            this.blocks.splice(index, 0, block);
            this.updateOrder();
        },
        deleteBlock(index) {
            this.blocks.splice(index, 1);
            this.updateOrder();
        },
        save() {
            this.updateOrder();
            this.$emit("save", this.blocks);
        },
        sanitize(blocks) {
            let newBlocks = blocks;

            newBlocks.forEach(function (value, index) {
                if (value.data === "") {
                    newBlocks[index].data = {};
                }
            });

            return newBlocks;
        },
    },
};
</script>

<style lang="scss">
.moving-card {
    @apply opacity-50 bg-gray-100 rounded-lg border border-blue-500;
}
</style>
