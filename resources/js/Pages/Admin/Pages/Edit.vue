<template>
    <div>
        <Header>
            <template #header>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">
                        Seite bearbeiten
                    </h2>
                    <p class="text-gray-600">Bearbeite den Inhalt der Seite.</p>
                </div>
            </template>
            <PrimaryButton> Vorschau anzeigen </PrimaryButton>
        </Header>

        <div class="flex flex-wrap pb-6">
            <PageEditor
                class="w-full"
                title="Bearbeiten"
                :page="page"
                :initial-blocks="page.blocks"
                @save="save"
            >
            </PageEditor>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import PageEditor from "@/Shared/PageEditor.vue";
import Header from "@/Shared/UI/Header.vue";
import PrimaryButton from "@/Shared/UI/PrimaryButton.vue";

export default {
    name: "Edit",
    components: { PrimaryButton, Header, PageEditor },
    layout: LayoutAdmin,
    props: {
        page: Object,
    },
    methods: {
        save(blocks) {
            let data = this.page;
            data.blocks = blocks;

            this.$inertia.put(
                this.route("admin.pages.update", this.page.id),
                data,
                {
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                    only: [],
                }
            );
        },
        preview() {
            this.$inertia.visit(
                this.route("admin.pages.preview", this.page.id)
            );
        },
    },
};
</script>

<style scoped></style>
