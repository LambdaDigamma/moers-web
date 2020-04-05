<template>

    <div class="h-full">
        <l-map
                :zoom="zoom"
                :center="center"
                @update:zoom="zoomUpdated"
                @update:center="centerUpdated"
                @update:bounds="boundsUpdated">
            <l-tile-layer style="height: 100%;" :url="url"></l-tile-layer>
            <l-marker v-for="entry in entries" :key="entry.id" :lat-lng="latLngForEntry(entry)">

            </l-marker>
        </l-map>

        <div class="absolute inset-y-0 right-0 w-1/5 h-full p-8 w-80" style="z-index: 500;">

            <div class="flex flex-col h-full overflow-hidden bg-white rounded-lg shadow-md">

                <div v-if="true">

                    <div class="relative pb-2/3">
                        <button class="absolute top-0 left-0">

                        </button>
                        <img class="absolute object-cover w-full h-full"
                             src="https://images.unsplash.com/photo-1464869372688-a93d806be852?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" />
                    </div>

                    <div class="p-4 border-b border-gray-200">
                        <h1 class="text-2xl font-semibold text-gray-900">Café Extrablatt</h1>
                    </div>

                    <div class="p-4 border-b border-gray-200">

                        <PrimaryButton size="lg" block>
                            Route
                        </PrimaryButton>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="col-span-1">
                                <WhiteButton size="lg" block>
                                    Anrufen
                                </WhiteButton>
                            </div>
                            <div class="col-span-1">
                                <WhiteButton size="lg" block>
                                    Webseite
                                </WhiteButton>
                            </div>
                        </div>

                    </div>

                    <div class="p-4 border-b border-gray-200">


                        <div class="text-sm text-gray-700">
                            <h2 class="text-base font-medium text-gray-900">Öffnungszeiten</h2>
                            <div class="grid grid-cols-3 gap-4 mt-2">
                                <div class="col-span-1">
                                    Montag
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Dienstag
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Mittwoch
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Donnerstag
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Freitag
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Samstag
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Sonntag
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    Sonstiges
                                </div>
                                <div class="col-span-2">
                                    12:00 - 16:00
                                </div>
                            </div>

                        </div>
                    </div>




                    <div class="p-4">

                        <div>
                            <span>
                                Neustraße 33b
                            </span>

                        </div>



                    </div>

                </div>


                <div v-else>
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
                    <div class="overflow-y-scroll">
                        <ul>
                            <li v-for="entry in entries" :key="entry.id" class="border-b border-gray-200">
                                <a href="#" class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="text-base font-medium leading-5 text-gray-900 truncate">
                                                {{ entry.name }}
                                            </div>
                                            <div class="flex flex-shrink-0 ml-2">
                                            <span v-if="false" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                Geöffnet
                                            </span>
                                                <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
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
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>

        </div>

    </div>

</template>

<script>
    import L from 'leaflet';
    import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import LayoutGeneralFluid from "../../Shared/Layouts/LayoutGeneralFluid";
    import { latLng } from "leaflet";
    import PrimaryButton from "../../Shared/UI/PrimaryButton";
    import WhiteButton from "../../Shared/UI/WhiteButton";

    export default {
        name: "Index",
        layout: LayoutGeneralFluid,
        components: {
            WhiteButton,
            PrimaryButton,
            LMap,
            LTileLayer,
            LMarker,
        },
        data () {
            return {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                zoom: 18,
                center: [51.4514, 6.6255],
            };
        },
        methods: {
            zoomUpdated (zoom) {
                this.zoom = zoom;
            },
            centerUpdated (center) {
                this.center = center;
            },
            boundsUpdated (bounds) {
                this.bounds = bounds;
            },
            latLngForEntry(entry) {
                return latLng(entry.lat, entry.lng)
            }
        },
        props: {
            entries: Array
        }
    }
</script>

<style scoped>

</style>