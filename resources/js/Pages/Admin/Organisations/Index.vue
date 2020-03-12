<template>

    <div class="lg:w-3/4">

        <h1 class="font-bold text-4xl dark:text-white">Organisationen</h1>

        <div class="mt-3 mb-6 flex flex-col md:flex-row justify-between items-center">
            <SearchFilter
                    v-model="form.search"
                    class="w-full max-w-sm mr-4"
                    @reset="reset">
                <label class="block dark:text-white">Gelöschte:</label>
                <select
                    v-model="form.trashed"
                    class="mt-1 w-full form-select">
                    <option :value="null"/>
                    <option value="with">inklusive gelöschten</option>
                    <option value="only">nur gelöschte</option>
                </select>
            </SearchFilter>
<!--            <inertia-link :href="route('admin..create')" class="px-3 py-2 bg-green-700 rounded-lg text-white font-semibold text-lg hover:no-underline">-->
<!--                <span>Erstellen</span>-->
<!--            </inertia-link>-->
        </div>

        <div>
            <inertia-link v-for="organisation in organisations.data"
                          :key="organisation.id"
                          :href="route('admin.organisations.edit', organisation.id)"
                          class="block mb-3 p-3 px-4 rounded-lg dark:bg-gray-700 dark:text-white">

                <h1 class="font-bold text-2xl">
                    {{ organisation.name }}
                </h1>
                <p class="font-medium text-base">
                    {{ organisation.description }}
                </p>

            </inertia-link>
        </div>

        <div class="p-0">
            <Pagination :links="organisations.links" class="my-2 my-md-4"></Pagination>
        </div>

    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import SearchFilter from "../../../Shared/SearchFilter";
    import {mapValues, pickBy, throttle} from "lodash";
    import Pagination from "../../../Shared/Pagination";

    export default {
        name: "Index",
        components: {Pagination, SearchFilter},
        layout: LayoutAdmin,
        props: {
            organisations: Object,
            filters: Object,
        },
        data() {
            return {
                form: {
                    search: this.filters.search,
                    trashed: this.filters.trashed,
                },
            }
        },
        watch: {
            form: {
                handler: throttle(function () {
                    let query = pickBy(this.form)
                    this.$inertia.replace(this.route('admin.organisations.index', Object.keys(query).length ? query : {remember: 'forget'}))
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