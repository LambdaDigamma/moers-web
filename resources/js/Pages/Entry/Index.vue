<template>

    <div class="h-full">

        <Map class="w-full h-full"
             :entries="entries"/>

        <div class="absolute inset-y-0 right-0 w-1/4 h-full p-8 w-80" style="z-index: 500;">

            <div class="flex flex-col h-full overflow-hidden bg-white rounded-lg shadow-md">

                <div v-if="selectedEntry" class="overflow-y-auto" scroll-region>

                    <EntryDetail :entry="selectedEntry" @close="closeDetail"></EntryDetail>

                </div>

                <div class="flex flex-col h-full" v-else>
                    <div class="flex-shrink-0 px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <div class="flex flex-wrap items-center justify-start -mt-4 -ml-4 sm:flex-no-wrap">
                            <div class="mt-4 ml-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Einträge
                                </h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    Sieh dir alle Einträge an.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-y-scroll" scroll-region>
                        <ul>
                            <li v-for="entry in entries" :key="entry.id" class="border-b border-gray-200">
                                <inertia-link :href="route('entries.index', entry.id)"
                                              class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50"
                                              @click.prevent.stop="showDetails(entry)">
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

    export default {
        name: "Index",
        layout: LayoutGeneralFluid,
        props: {
            entries: Array,
            selectedEntry: {
                type: Object,
                required: false
            }
        },
        components: {
            Map,
            EntryDetail,
            WhiteButton,
            PrimaryButton,
        },
        methods: {
            showDetails(entry) {
                this.$inertia.replace(this.route('entries.index', entry.id), {
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
            }
        }
    }
</script>

<style scoped>

</style>