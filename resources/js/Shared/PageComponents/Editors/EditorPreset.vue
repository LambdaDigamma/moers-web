<template>
    <Panel class="w-full">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6" slot="heading">
            <div
                class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap"
            >
                <div class="mt-4 ml-4">
                    <div class="flex items-center">
                        <div
                            class="flex-shrink-0 w-12 h-12 p-3 bg-gray-900 rounded-full"
                        >
                            <svg
                                class="text-white"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                                ></path>
                                <path
                                    fill-rule="evenodd"
                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Markdown
                            </h3>
                            <p class="text-sm leading-5 text-gray-500">
                                Nutze Markdown, um diesen Text-Block zu
                                gestalten.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-shrink-0 mt-4 ml-4">
                    <span class="inline-flex rounded-md shadow-sm">
                        <button
                            type="button"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue focus:border-blue-300 active:bg-gray-50 active:text-gray-800"
                        >
                            <svg
                                class="w-5 h-5 mr-2 -ml-1 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z"
                                ></path>
                                <path
                                    d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z"
                                ></path>
                            </svg>
                            <span> Duplizieren </span>
                        </button>
                    </span>

                    <span class="inline-flex ml-3 rounded-md shadow-sm">
                        <button
                            type="button"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue focus:border-blue-300 active:bg-gray-50 active:text-gray-800"
                        >
                            <svg
                                class="w-5 h-5 mr-2 -ml-1 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <span> Löschen </span>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-row w-full">
            <slot />
        </div>
    </Panel>
</template>

<script>
import Icon from "../../Icon.vue";
import Panel from "../../UI/Panels/Panel.vue";
export default {
    name: "EditorPreset",
    components: { Panel, Icon },
    props: {
        border: {
            type: Boolean,
            default: () => true,
        },
    },
    methods: {
        duplicateBlock() {
            this.$emit("duplicated");
            if (this.$parent) {
                this.$parent.$emit("duplicated");
            }
        },
        deleteBlock() {
            this.$emit("deleted");
            if (this.$parent) {
                this.$parent.$emit("deleted");
            }
        },
    },
};
</script>

<style scoped></style>
