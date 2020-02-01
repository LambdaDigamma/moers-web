<template>

    <div class="flex flex-row">
        <div class="lg:w-3/4">
            <CardContainer class="lg:mr-2" :show-action-bar="false">
                <template v-slot:header>
                    <h1 class="font-semibold text-2xl dark:text-white">
                        {{ title }}
                    </h1>
                </template>
                <div class="rounded-lg" :class="{ 'border dark:border-gray-600' : blocks.length === 0 }">
                    <div>
                        <draggable :list="blocks" group="blocks">
                            <div v-for="(block, index) in blocks"
                                 :key="index"
                                 class="flex flex-row items-center dark:text-white">

                                <TextEditor
                                        v-if="block.type === 'markdown'"
                                        :block="block"
                                        @duplicated="duplicateBlock(index)"
                                        @deleted="deleteBlock(index)" />
                                <SoundCloudEditor
                                        v-else-if="block.type === 'soundcloud'"
                                        @duplicated="duplicateBlock(index)"
                                        @deleted="deleteBlock(index)" />

                                <div v-else class="py-3 w-full  flex flex-row items-center justify-center dark:text-white">
                                    Dieser Baustein wird leider noch nicht unterstützt.
                                </div>
                            </div>
                            <div v-if="blocks.length === 0" class="py-3 flex flex-row items-center justify-center dark:text-white">
                                Ziehe die gewünschten Inhalte aus dem Kasten rechts in die Bearbeitungsfläche.
                            </div>
                        </draggable>
                    </div>

                </div>
            </CardContainer>
        </div>
        <div class="lg:w-1/4">
            <CardContainer class="lg:ml-2" :inset-container="false">
<!--                <input @keydown.enter.prevent=""-->
<!--                       v-model="query"-->
<!--                       placeholder="Suchen…"-->
<!--                       type="text"-->
<!--                       class="w-full px-2 py-2 md:px-2 md:py-3 rounded focus:shadow-outline dark:text-white dark:bg-gray-600" />-->
                <div class="pt-3 px-3">
                    <draggable
                            :list="presets"
                            :group="{ name: 'blocks', pull: 'clone' }"
                            :clone="clone">
                        <div v-for="(preset, index) in presets"
                             :key="index"
                             class="py-2 flex flex-row items-center dark:text-white">
                            <Icon :name="preset.icon" class="h-10 w-10 pr-2 fill-current" />
                            <div>
                                <h1 class="mb-1 font-semibold text-lg">{{ preset.name }}</h1>
                                <p class="mb-0 font-normal text-sm">{{ preset.description }}</p>
                            </div>
                        </div>
                    </draggable>
                </div>


            </CardContainer>
            <CardContainer class="mt-4 lg:ml-2">
                <div class="flex flex-col">
                    <button class="px-3 py-2 font-semibold text-lg rounded-lg dark:bg-yellow-500 dark:text-gray-900 dark-hover:bg-yellow-600"
                            @click="save">
                        Speichern
                    </button>
                </div>
            </CardContainer>
        </div>
    </div>

</template>

<script>
    import CardContainer from "./UI/CardContainer";
    import Icon from "./Icon";
    import draggable from 'vuedraggable';
    import TextEditor from "./PageComponents/Editors/TextEditor";
    import SoundCloudEditor from "./PageComponents/Editors/SoundCloudEditor";

    export default {
        name: "PageEditor",
        components: {SoundCloudEditor, TextEditor, Icon, CardContainer, draggable},
        props: {
            title: {
                type: String,
                default: () => "Beschreibungsseite"
            },
            initialBlocks: {
                type: Array,
                default: () => []
            }
        },
        data() {
            return {
                query: null,
                blocks: this.initialBlocks,
                presets: [
                    {
                        "type": "markdown",
                        "name": "Text",
                        "description": "Füge einen Textblock hinzu.",
                        "icon": "paragraph"
                    },
                    {
                        "type": "image",
                        "name": "Bild",
                        "description": "Füge ein Bild hinzu.",
                        "icon": "image"
                    },
                    {
                        "type": "soundcloud",
                        "name": "Soundcloud Track",
                        "description": "Füge einen Soundcloud Track hinzu.",
                        "icon": "dashboard"
                    }
                ]
            }
        },
        methods: {
            clone(obj) {
                return {
                    type: obj.type,
                    data: {}
                }
            },
            duplicateBlock(index) {
                const block = this.blocks[index]
                this.blocks.splice(index, 0, block)
            },
            deleteBlock(index) {
                this.blocks.splice(index, 1)
            },
            save() {
                this.$emit('save', this.blocks)
            }
        }
    }
</script>

<style scoped>

</style>