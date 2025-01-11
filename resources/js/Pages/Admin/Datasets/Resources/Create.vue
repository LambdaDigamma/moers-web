<template>
    <div>
        <ResourceGeneralForm :form="form" @submit="submit"> </ResourceGeneralForm>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import ResourceGeneralForm from "./ResourceGeneralForm.vue";
import { useForm } from "@inertiajs/vue3";

export default {
    name: "Create",
    components: { ResourceGeneralForm },
    layout: LayoutAdmin,
    remember: "form",
    props: {
        dataset: Object,
    },
    setup() {
        const form = useForm({
            name: "",
            format: "json",
            shouldAutoImport: true,
            autoUpdatingInterval: 24,
        });

        const submit = () => {
            form.post(
                this.route("admin.datasets.resources.store", props.dataset.id)
            );
        };

        return {
            form,
            submit,
        };
    },
};
</script>

<style scoped></style>
