<template>
    <div class="flex items-center justify-between max-w-3xl p-4 bg-red-600 rounded">
        <div class="flex items-center">
            <icon name="trash" class="flex-shrink-0 w-4 h-4 mr-2 fill-white" />
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
