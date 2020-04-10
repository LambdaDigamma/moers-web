<template>

    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Datensätze</h1>

        <div class="grid grid-cols-3 mt-6">
            <inertia-link class="col-span-1 overflow-hidden bg-white rounded-lg shadow hover:bg-gray-50"
                          v-for="dataset in datasets.data"
                          :key="dataset.id"
                          :href="route('admin.datasets.edit', dataset.id)">
                <div class="px-4 py-4">
                    <h2 class="font-semibold text-gray-900 text-lg">{{ dataset.name }}</h2>
                    <p class="font-medium text-gray-500 text-base" v-if="dataset.resources_count === 1">
                        {{ dataset.resources_count }} Resource
                    </p>
                    <p class="font-medium text-gray-500 text-base" v-else>
                        {{ dataset.resources_count }} Resourcen
                    </p>
                </div>
            </inertia-link>
        </div>
        

    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";

    export default {
        name: "Index",
        layout: LayoutAdmin,
        props: {
            datasets: {
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>