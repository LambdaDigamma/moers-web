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
    import TextInput from "../../../../Shared/TextInput";
    import SelectInput from "../../../../Shared/UI/SelectInput";
    import ResourceGeneralForm from "./ResourceGeneralForm";

    export default {
        name: "Create",
        components: {ResourceGeneralForm, SelectInput, TextInput},
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