<template>

    <div>
        <Header
                :href="route('admin.pages.index')"
                previousTitle="Seiten"
                class="mb-8">
            {{ page.title }}
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
            }
        }
    }
</script>

<style scoped>

</style>