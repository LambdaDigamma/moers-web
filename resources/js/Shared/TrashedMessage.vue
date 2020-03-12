<template>
    <div class="p-4 bg-red-600 rounded flex items-center justify-between max-w-3xl">
        <div class="flex items-center">
            <icon name="trash" class="flex-shrink-0 w-4 h-4 fill-white mr-2" />
            <div class="text-white">
                <slot />
            </div>
        </div>
        <button class="text-white hover:underline" tabindex="-1" type="button" @click="$emit('restore')">
            Wiederherstellen
        </button>
    </div>
</template>

<script>
    import Icon from '@/Shared/Icon'

    export default {
        components: {
            Icon,
        },
    }
</script>
