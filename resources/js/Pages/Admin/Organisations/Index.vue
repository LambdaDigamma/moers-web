<template>

    <div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">


            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-no-wrap">
                    <div class="ml-4 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Organisationen
                        </h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Organisationen sind Vereine, Behörden oder Gruppen von Gleichgesinnten
                        </p>
                    </div>
                    <div class="ml-4 mt-4 flex-shrink-0">
                        <span class="inline-flex rounded-md shadow-sm">
                            <a :href="route('admin.organisations.create')" class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:shadow-outline-green focus:border-green-700 active:bg-green-700">
                                Neue erstellen
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="">
                <ul>
                    <li class="border-t border-gray-200" v-for="organisation in organisations.data">
                        <inertia-link :href="route('admin.organisations.edit', organisation.id)"
                                      class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                    </div>
                                    <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                        <div>
                                            <div class="text-sm leading-5 font-semibold text-gray-900 truncate">{{ organisation.name }}</div>
                                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="truncate">{{ organisation.description }}</span>
                                            </div>
                                        </div>
                                        <div class="hidden md:block">
                                            <div>
                                                <div class="flex items-center text-sm leading-5 text-gray-900">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                    </svg>
                                                    <span v-if="organisation.entry">
                                                        {{ organisation.entry.name }}
                                                    </span>
                                                    <span v-else>
                                                        Ort nicht eingetragen
                                                    </span>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Seite aufgesetzt
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </inertia-link>
                    </li>
                </ul>
            </div>


<!--            {{ organisations.links }}-->

            <PaginationCardFooter
                :links="organisations.links"
                :total-items="10">

            </PaginationCardFooter>


        </div>




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
    import PaginationCardFooter from "../../../Shared/CardComponents/PaginationCardFooter";

    export default {
        name: "Index",
        components: {PaginationCardFooter, Pagination, SearchFilter},
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