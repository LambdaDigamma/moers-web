<template>

    <div class="py-3 flex flex-row dark:text-white w-full" :class="{ 'border-t dark:border-gray-600' : border }">
        <div class="pt-4 flex flex-col flex-shrink-0 items-center w-40 bg-gray-100 rounded-lg">
            <slot name="pre" />
            <div class="mt-3 flex flex-row flex-wrap justify-start">
                <button class="px-3 py-2 font-semibold text-sm rounded-lg bg-blue-500 text-white dark:bg-blue-600 dark-hover:bg-blue-700 dark:text-white"
                        id="duplicate"
                        @click="duplicateBlock">
                    <Icon name="duplicate" class="fill-current h-3 w-3" />
                </button>
                <button class="ml-2 px-3 py-2 font-semibold text-sm rounded-lg bg-red-500 text-white dark:bg-red-600 dark-hover:bg-red-700 dark:text-white"
                        aria-label="delete"
                        id="delete"
                        @click.prevent="deleteBlock">
                    <Icon name="trash" class="fill-current h-3 w-3" />
                </button>
            </div>
        </div>
        <div class="pl-3 flex-grow-1 w-full">
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