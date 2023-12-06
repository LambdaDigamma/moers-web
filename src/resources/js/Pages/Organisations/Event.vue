<template>
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ event.name }}</h1>
    </div>
</template>

<script>
import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral.vue";

export default {
    name: "Event",
    layout: LayoutGeneral,
    props: {
        organisation: {
            type: Object,
        },
        event: {
            type: Object,
        },
    },
};
</script>

<style scoped></style>
