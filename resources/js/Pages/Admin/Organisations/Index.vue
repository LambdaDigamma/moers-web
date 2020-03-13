<template>

    <div>



        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                <h1 class="text-2xl font-semibold text-gray-900">Organisationen</h1>
                <!-- Content goes here -->
                <!-- We use less vertical padding on card headers on desktop than on body sections -->
            </div>
            <div class="px-4 py-5 sm:p-6">
                <!-- Content goes here -->
            </div>
        </div>






<!--        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">-->
<!--            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">-->
<!--                <div class="ml-4 mt-2">-->
<!--                    <h3 class="text-lg leading-6 font-medium text-gray-900">-->
<!--                        Organisationen-->
<!--                    </h3>-->
<!--                </div>-->
<!--                <div class="ml-4 mt-2 flex-shrink-0">-->
<!--                    <span class="inline-flex rounded-md shadow-sm">-->
<!--                        <button type="button"-->
<!--                                class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700">-->
<!--                            Create new job-->
<!--                        </button>-->
<!--                    </span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->


        <!--        <h1 class="font-bold text-4xl dark:text-white">Organisationen</h1>-->

        <!--        <div class="mt-3 mb-6 flex flex-col md:flex-row justify-between items-center">-->
        <!--            <SearchFilter-->
        <!--                    v-model="form.search"-->
        <!--                    class="w-full max-w-sm mr-4"-->
        <!--                    @reset="reset">-->
        <!--                <label class="block dark:text-white">Gelöschte:</label>-->
        <!--                <select-->
        <!--                    v-model="form.trashed"-->
        <!--                    class="mt-1 w-full form-select">-->
        <!--                    <option :value="null"/>-->
        <!--                    <option value="with">inklusive gelöschten</option>-->
        <!--                    <option value="only">nur gelöschte</option>-->
        <!--                </select>-->
        <!--            </SearchFilter>-->
        <!--&lt;!&ndash;            <inertia-link :href="route('admin..create')" class="px-3 py-2 bg-green-700 rounded-lg text-white font-semibold text-lg hover:no-underline">&ndash;&gt;-->
        <!--&lt;!&ndash;                <span>Erstellen</span>&ndash;&gt;-->
        <!--&lt;!&ndash;            </inertia-link>&ndash;&gt;-->
        <!--        </div>-->

        <!--        <div>-->
        <!--            <inertia-link v-for="organisation in organisations.data"-->
        <!--                          :key="organisation.id"-->
        <!--                          :href="route('admin.organisations.edit', organisation.id)"-->
        <!--                          class="block mb-3 p-3 px-4 rounded-lg dark:bg-gray-700 dark:text-white">-->

        <!--                <h1 class="font-bold text-2xl">-->
        <!--                    {{ organisation.name }}-->
        <!--                </h1>-->
        <!--                <p class="font-medium text-base">-->
        <!--                    {{ organisation.description }}-->
        <!--                </p>-->

        <!--            </inertia-link>-->
        <!--        </div>-->

        <!--        <div class="p-0">-->
        <!--            <Pagination :links="organisations.links" class="my-2 my-md-4"></Pagination>-->
        <!--        </div>-->

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