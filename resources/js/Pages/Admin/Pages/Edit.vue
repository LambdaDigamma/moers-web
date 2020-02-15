<template>

    <div>
        <Header
                :href="route('admin.pages.index')"
                previousTitle="Seiten"
                class="mb-8">
            <div class="inline-flex flex-row items-center">
                {{ page.title }}
                <button class="ml-3 px-2 py-1 font-semibold text-sm rounded-lg dark:bg-blue-500 dark:text-white dark-hover:bg-blue-600"
                        @click="preview">
                    Vorschau anzeigen
                </button>
            </div>
        </Header>
        <div class="flex flex-wrap pb-6">

            <PageEditor
                    class="w-full"
                    title="Bearbeiten"
                    :initial-blocks="page.blocks"
                    @save="save">

            </PageEditor>

        </div>
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import PageEditor from "../../../Shared/PageEditor";

    export default {
        name: "Edit",
        components: {PageEditor},
        layout: LayoutAdmin,
        props: {
            page: Object,
        },
        methods: {
            save(blocks) {

                let data = this.page
                data.blocks = blocks

                this.$inertia.put(this.route('admin.pages.update', this.page.id), data, {
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                    only: [],
                })
            },
            preview() {
                this.$inertia.visit(this.route('admin.pages.preview', this.page.id))
            },
        }
    }
</script>

<style scoped>

</style>