<template>

    <div>

        <div class="overflow-hidden bg-white rounded-lg shadow-sm">


            <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-no-wrap">
                    <div class="mt-4 ml-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Organisationen
                        </h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Organisationen sind Vereine, Behörden oder Gruppen von Gleichgesinnten
                        </p>
                    </div>
                    <div class="flex-shrink-0 mt-4 ml-4">
                        <span class="inline-flex rounded-md shadow-sm">
                            <a :href="route('admin.organisations.create')" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white bg-green-600 border border-transparent rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green focus:border-green-700 active:bg-green-700">
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
                                      class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <img class="w-12 h-12 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                    </div>
                                    <div class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-4">
                                        <div>
                                            <div class="text-sm font-semibold leading-5 text-gray-900 truncate">{{ organisation.name }}</div>
                                            <div class="flex items-center mt-2 text-sm leading-5 text-gray-500">
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
                                                <div class="flex items-center mt-2 text-sm leading-5 text-gray-500">
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
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
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




        <!--        <h1 class="text-4xl font-bold dark:text-white">Organisationen</h1>-->

        <!--        <div class="flex flex-col items-center justify-between mt-3 mb-6 md:flex-row">-->
        <!--            <SearchFilter-->
        <!--                    v-model="form.search"-->
        <!--                    class="w-full max-w-sm mr-4"-->
        <!--                    @reset="reset">-->
        <!--                <label class="block dark:text-white">Gelöschte:</label>-->
        <!--                <select-->
        <!--                    v-model="form.trashed"-->
        <!--                    class="w-full mt-1 form-select">-->
        <!--                    <option :value="null"/>-->
        <!--                    <option value="with">inklusive gelöschten</option>-->
        <!--                    <option value="only">nur gelöschte</option>-->
        <!--                </select>-->
        <!--            </SearchFilter>-->
        <!--&lt;!&ndash;            <inertia-link :href="route('admin..create')" class="px-3 py-2 text-lg font-semibold text-white bg-green-700 rounded-lg hover:no-underline">&ndash;&gt;-->
        <!--&lt;!&ndash;                <span>Erstellen</span>&ndash;&gt;-->
        <!--&lt;!&ndash;            </inertia-link>&ndash;&gt;-->
        <!--        </div>-->

        <!--        <div>-->
        <!--            <inertia-link v-for="organisation in organisations.data"-->
        <!--                          :key="organisation.id"-->
        <!--                          :href="route('admin.organisations.edit', organisation.id)"-->
        <!--                          class="block p-3 px-4 mb-3 rounded-lg dark:bg-gray-700 dark:text-white">-->

        <!--                <h1 class="text-2xl font-bold">-->
        <!--                    {{ organisation.name }}-->
        <!--                </h1>-->
        <!--                <p class="text-base font-medium">-->
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