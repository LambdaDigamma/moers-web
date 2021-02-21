<template>

    <div class="h-full">

        <Map class="w-full h-full"
             :entries="entries"
             @selected="showDetails($event.annotation.data.id)"
             @deselected="closeDetail" />

        <div class="absolute inset-y-0 right-0 w-1/4 h-full p-8 w-80" style="z-index: 500;">

            <div class="flex flex-col h-full overflow-hidden bg-white rounded-lg shadow-md">

                <div v-if="selectedEntry" class="overflow-y-auto" scroll-region>

                    <EntryDetail :entry="selectedEntry" @close="closeDetail"></EntryDetail>

                </div>

                <div class="flex flex-col h-full" v-else>
                    <div class="flex-shrink-0 px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <div class="w-full">
                            <label for="search" class="sr-only">Eintrag suchen…</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="search"
                                       class="block w-full py-2 pr-3 leading-5 placeholder-gray-600 transition duration-150 ease-in-out border border-transparent rounded-md pl-7 focus:outline-none sm:text-base"
                                       placeholder="Eintrag suchen…"
                                       type="search"
                                       v-model="form.search" />
                            </div>
                        </div>
<!--                        <div class="flex flex-wrap items-center justify-start -mt-4 -ml-4 sm:flex-nowrap">-->
<!--                            <div class="mt-4 ml-4">-->
<!--                                <h3 class="text-lg font-medium leading-6 text-gray-900">-->
<!--                                    Einträge-->
<!--                                </h3>-->
<!--                                <p class="mt-1 text-sm leading-5 text-gray-500">-->
<!--                                    Sieh dir alle Einträge an.-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div v-if="true" class="flex flex-wrap border-b border-gray-200 px-4 sm:px-6 py-3">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-indigo-100 text-indigo-800">
                          Restaurant
                          <button type="button" class="flex-shrink-0 -mr-0.5 ml-1.5 inline-flex text-indigo-500 focus:outline-none focus:text-indigo-700">
                            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                              <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                            </svg>
                          </button>
                        </span>
                    </div>
                    <div class="overflow-y-scroll" scroll-region>
                        <ul>
                            <li v-for="entry in entries" :key="entry.id" class="border-b border-gray-200">
                                <inertia-link :href="route('entries.index', entry.id)"
                                              class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50"
                                              @click.prevent.stop="showDetails(entry.id)">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="text-base font-medium leading-5 text-gray-900 truncate">
                                                {{ entry.name }}
                                            </div>
                                            <div class="flex flex-shrink-0 ml-2">
                                            <span v-if="false"
                                                  class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                Geöffnet
                                            </span>
                                                <span v-else
                                                      class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                                Geschlossen
                                            </span>
                                            </div>
                                        </div>
                                        <div class="mt-0">
                                        <span class="text-sm leading-5 text-gray-500">
                                            <span v-if="entry.street">
                                                {{ entry.street }}
                                            </span>
                                            <span v-if="entry.house_number">
                                                {{ entry.house_number }}
                                            </span>
                                        </span>
                                        </div>
                                    </div>
                                </inertia-link>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>

        </div>

    </div>

</template>

<script>
    import LayoutGeneralFluid from "../../Shared/Layouts/LayoutGeneralFluid";
    import PrimaryButton from "../../Shared/UI/PrimaryButton";
    import WhiteButton from "../../Shared/UI/WhiteButton";
    import EntryDetail from "../../Shared/Entry/EntryDetail";
    import Map from "../../Shared/Map/Map";
    import {mapValues, pickBy, throttle} from "lodash";

    export default {
        name: "Index",
        layout: LayoutGeneralFluid,
        props: {
            entries: Array,
            selectedEntry: {
                type: Object,
                required: false
            },
            filters: Object,
        },
        components: {
            Map,
            EntryDetail,
            WhiteButton,
            PrimaryButton,
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
                    this.$inertia.replace(this.route('entries.index', Object.keys(query).length ? query : {remember: 'forget'}), {
                        only: ['entries'],
                    })
                }, 150),
                deep: true,
            },
        },
        methods: {
            showDetails(id) {
                this.$inertia.replace(this.route('entries.index', id), {
                    method: 'get',
                    data: {},
                    preserveState: true,
                    preserveScroll: true,
                    only: ['selectedEntry'],
                })
            },
            closeDetail() {
                this.$inertia.replace(this.route('entries.index'), {
                    method: 'get',
                    data: {},
                    preserveState: true,
                    preserveScroll: true,
                    only: ['selectedEntry'],
                })
            },
            reset() {
                this.form = mapValues(this.form, () => null)
            },
        }
    }
</script>

<style scoped>

</style>