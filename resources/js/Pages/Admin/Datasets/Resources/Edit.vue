<template>

    <div class="mb-12">

        <ResourceGeneralForm
                :resource="resource"
                @changed="changed"
                @submit="submit">

        </ResourceGeneralForm>

        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">


            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center rounded-full w-12 h-12"
                                     :class="{ 'bg-green-500': resource.error === null, 'bg-red-500': resource.error !== null }">
                                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-8 h-8 text-white">
                                        <path v-if="resource.error === null" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        <path v-else fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    <span v-if="resource.error === null">Status: Valide Daten</span>
                                    <span v-else>Status: Invalide Daten</span>
                                </h3>
                                <p class="text-sm leading-5 text-gray-500">
                                    <a href="#">
                                        Letzte Aktualisierung: {{ resource.updated_at | moment("from", "now") }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 mt-4 flex-shrink-0 flex">
                        <WhiteButton :href="route('admin.datasets.resources.updateData', [dataset.id, resource.id])" method="post">
                            Aktualisieren
                        </WhiteButton>
                    </div>
                </div>
            </div>

            <div v-if="resource.error !== null" class="px-4 py-3 sm:px-6 sm:py-4 bg-red-200">
                <h4 class="text-red-800 font-medium">
                    Fehlerhaftes Format
                </h4>
                <p class="text-xs text-red-700 font-mono" v-for="line in resource.error.split('\n')">
                    {{line}}<br>
                </p>
            </div>

<!--            <div class="px-4 py-5 sm:p-6">-->
<!--                <div class="bg-gray-100 overflow-hidden rounded-lg">-->
<!--                    <div class="px-4 py-5 sm:p-6 h-96 overflow-y-auto">-->
<!--                        <code>-->
<!--                            {-->
<!--                                "de": "Test"-->
<!--                            }-->
<!--                        </code>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>

    </div>

</template>

<script>
    import ResourceGeneralForm from "./ResourceGeneralForm";
    import LayoutAdmin from "../../../../Shared/LayoutAdmin";
    import WhiteButton from "../../../../Shared/UI/WhiteButton";
    export default {
        name: "Edit",
        components: {WhiteButton, ResourceGeneralForm},
        layout: LayoutAdmin,
        remember: 'form',
        props: {
            dataset: Object,
            resource: Object
        },
        data() {
            return {
                form: null,
                validData: false
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