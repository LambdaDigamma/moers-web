<template>

    <div class="py-3 flex flex-row dark:text-white w-full" :class="{ 'border-t dark:border-gray-600' : border }">
        <div class="flex flex-col items-center w-40">
            <slot name="pre" />
            <div class="mt-3 flex flex-row flex-wrap justify-start">
                <button class="px-3 py-2 font-semibold text-sm rounded-lg dark:bg-blue-600 dark-hover:bg-blue-700 dark:text-white">
                    <Icon name="duplicate" class="fill-current h-3 w-3" />
                </button>
                <button class="ml-2 px-3 py-2 font-semibold text-sm rounded-lg dark:bg-red-600 dark-hover:bg-red-700 dark:text-white"
                        @click.prevent="$parent.$emit('delete-block')">
                    <Icon name="trash" class="fill-current h-3 w-3" />
                </button>
            </div>
        </div>
        <div class="pl-3 flex-grow-1">
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
        }
    }
</script>

<style scoped>

</style>