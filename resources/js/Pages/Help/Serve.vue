<template>

    <div class="mt-6">

        <div v-if="activeRequests && activeRequests.length !== 0" class="mb-12">

            <h1 class="mb-6 text-3xl font-bold leading-tight text-gray-900">
                Hier hilfst du gerade:
            </h1>

            <HelpItem v-for="(request, index) in activeRequests" :key="index" :request="request" class="my-3" />

        </div>

        <h2 class="text-3xl font-bold leading-tight text-gray-900">
            Hier kannst du helfen:
        </h2>

        <div class="mt-6">
            <div class="flex w-full px-4 py-2 bg-white rounded-lg shadow sm:p-6 md:py-3">
                <label for="search_field" class="sr-only">Suchen</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                        </svg>
                    </div>
                    <input id="search_field" class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 rounded-md focus:outline-none focus:placeholder-gray-400 sm:text-sm" placeholder="Suche nach Stadtteil oder Schlagwort" v-model="form.search" />
                </div>
            </div>
        </div>

        <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <p class="max-w-4xl">
                    Momentan benötigt hier niemand deine Hilfe. Aber schaue in der nächsten Zeit noch mal nach!
                </p>
            </div>
        </div>

        <HelpItem v-for="(request, index) in helpRequests.data" :key="index" :request="request" class="mt-6" />

        <Pagination :links="helpRequests.links" class="mt-4" />

    </div>

</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import HelpItem from "../../Shared/Help/HelpItem";
    import {mapValues, pickBy, throttle} from "lodash";
    import Pagination from "../../Shared/Pagination";

    export default {
        name: "Serve",
        components: {Pagination, HelpItem},
        layout: LayoutGeneral,
        props: {
            helpRequests: Object,
            filters: Object,
            activeRequests: Array
        },
        data() {
            return {
                form: {
                    search: this.filters.search,
                },
            }
        },
        watch: {
            form: {
                handler: throttle(function () {
                    let query = pickBy(this.form)
                    this.$inertia.replace(this.route('help.serve', Object.keys(query).length ? query : { remember: 'forget' }).url())
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = mapValues(this.form, () => null)
            },
        },
    }
</script>

<style scoped>

</style>