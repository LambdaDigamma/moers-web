<template>

    <div class="flex flex-row w-full py-3 dark:text-white" :class="{ 'border-t dark:border-gray-600' : border }">
        <div class="flex flex-col items-center flex-shrink-0 w-40 pt-4 bg-gray-100 rounded-lg">
            <slot name="pre" />
            <div class="flex flex-row flex-wrap justify-start mt-3">
                <button class="px-3 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg dark:bg-blue-600 dark-hover:bg-blue-700 dark:text-white"
                        id="duplicate"
                        @click="duplicateBlock">
                    <Icon name="duplicate" class="w-3 h-3 fill-current" />
                </button>
                <button class="px-3 py-2 ml-2 text-sm font-semibold text-white bg-red-500 rounded-lg dark:bg-red-600 dark-hover:bg-red-700 dark:text-white"
                        aria-label="delete"
                        id="delete"
                        @click.prevent="deleteBlock">
                    <Icon name="trash" class="w-3 h-3 fill-current" />
                </button>
            </div>
        </div>
        <div class="w-full pl-3 flex-grow-1">
            <slot />
        </div>
    </div>

</template>

<script>
    import Icon from "../../Icon";
    export default {
        name: "EditorPreset",
        components: {Icon},
        props: {
            border: {
                type: Boolean,
                default: () => true
            }
        },
        methods: {
            duplicateBlock() {
                this.$emit('duplicated')
                if (this.$parent) {
                    this.$parent.$emit('duplicated')
                }
            },
            deleteBlock() {
                this.$emit('deleted')
                if (this.$parent) {
                    this.$parent.$emit('deleted')
                }
            }
        }
    }
</script>

<style scoped>

</style>