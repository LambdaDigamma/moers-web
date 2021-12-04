<template>
    <div>
        <Header
            :href="route('admin.pages.index')"
            previousTitle="Seiten"
            class="mb-8"
        >
            <div class="inline-flex flex-row items-center">
                {{ page.title }}
                <span
                    class="px-2 py-2 ml-3 text-base font-semibold rounded-lg dark:bg-gray-600 dark:text-gray-800"
                    >Vorschau</span
                >
            </div>
        </Header>

        <div class="flex flex-row">
            <div class="lg:w-3/4">
                <CardContainer class="lg:mr-2" :show-action-bar="false">
                    <div v-for="block in page.blocks">
                        <MarkdownPresentation
                            v-if="block.type === 'markdown'"
                            :block="block"
                        />
                    </div>
                </CardContainer>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import MarkdownPresentation from "@/Shared/PageComponents/Presentation/MarkdownPresentation.vue";

export default {
    name: "Preview",
    components: { MarkdownPresentation },
    layout: LayoutAdmin,
    props: {
        page: Object,
    },
};
</script>

<style scoped></style>
