<template>

    <div>

        <ResourceGeneralForm
                @changed="changed"
                @submit="submit">

        </ResourceGeneralForm>

    </div>

</template>

<script>
    import LayoutAdmin from "../../../../Shared/LayoutAdmin";
    import ResourceGeneralForm from "./ResourceGeneralForm";

    export default {
        name: "Create",
        components: {ResourceGeneralForm},
        layout: LayoutAdmin,
        remember: 'form',
        props: {
            dataset: Object
        },
        data() {
            return {
                form: null
            }
        },
        methods: {
            changed(formData) {
                this.form = formData
            },
            submit(formData) {
                this.$inertia
                    .post(this.route('admin.datasets.resources.store', this.dataset.id), formData)
            },
        }
    }
</script>

<style scoped>

</style>