<template>

    <div>
        <Header title="Organisationen">
            <PrimaryButton>
                Organisation erstellen
            </PrimaryButton>
        </Header>

        <div>
            <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <li class="col-span-1 bg-white rounded-lg shadow" v-for="organisation in organisations.data">
                    <div class="w-full flex items-center justify-between p-6 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-gray-900 text-base leading-5 font-medium truncate">
                                    {{ organisation.name }}
                                </h3>
                            </div>
                            <p class="mt-1 text-gray-500 text-sm leading-5 truncate">
                                {{ organisation.description }}
                            </p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="-mt-px flex">
                            <div class="w-0 flex-1 flex border-r border-gray-200">

                            </div>
                            <div class="-ml-px w-0 flex-1 flex">
                                <inertia-link :href="route('admin.organisations.edit', [organisation.id])"
                                              class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm leading-5 text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                    <span class="ml-3">
                                        Bearbeiten
                                    </span>
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <Pagination class="mt-6" :links="organisations.links"></Pagination>

    </div>
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import SearchFilter from "../../../Shared/SearchFilter";
    import {mapValues, pickBy, throttle} from "lodash";
    import Pagination from "../../../Shared/Pagination";
    import PaginationCardFooter from "../../../Shared/CardComponents/PaginationCardFooter";
    import PrimaryButton from "../../../Shared/UI/PrimaryButton";

    export default {
        name: "Index",
        components: {PrimaryButton, PaginationCardFooter, Pagination, SearchFilter},
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