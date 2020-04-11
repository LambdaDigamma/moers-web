<template>

    <div>

        <ResourceGeneralForm
                :resource="resource"
                @changed="changed"
                @submit="submit">

        </ResourceGeneralForm>

    </div>

</template>

<script>
    import ResourceGeneralForm from "./ResourceGeneralForm";
    import LayoutAdmin from "../../../../Shared/LayoutAdmin";
    export default {
        name: "Edit",
        components: {ResourceGeneralForm},
        layout: LayoutAdmin,
        remember: 'form',
        props: {
            dataset: Object,
            resource: Object
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
                formData.append('_method', 'put')
                this.$inertia
                    .post(this.route('admin.datasets.resources.update', [this.dataset.id, this.resource.id]), formData)
            },
        }
    }
</script>

<style scoped>

</style>