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

        <div class="absolute w-80 w-1/5 h-full inset-y-0 right-0 p-8" style="z-index: 500;">

            <div class="flex flex-col bg-white h-full shadow-md rounded-lg overflow-hidden">

                <div v-if="true">

                    <div class="pb-2/3 relative">
                        <button class="absolute top-0 left-0">

                        </button>
                        <img class="absolute h-full w-full object-cover"
                             src="https://images.unsplash.com/photo-1464869372688-a93d806be852?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" />
                    </div>

                    <div class="border-b border-gray-200 p-4">
                        <h1 class="text-gray-900 font-semibold text-2xl">Café Extrablatt</h1>
                    </div>

                    <div class="border-b border-gray-200 p-4">

                        <PrimaryButton size="lg" block>
                            Route
                        </PrimaryButton>

                        <div class="mt-4 grid grid-cols-2 gap-4">
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

                    <div class="border-b border-gray-200 p-4">


                        <div class="text-sm text-gray-700">
                            <h2 class="text-gray-900 text-base font-medium">Öffnungszeiten</h2>
                            <div class="mt-2 grid grid-cols-3 gap-4">
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
                    <div class="flex-shrink-0 bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="-ml-4 -mt-4 flex justify-start items-center flex-wrap sm:flex-no-wrap">
                            <div class="ml-4 mt-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
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
                                <a href="#" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="text-base leading-5 font-medium text-gray-900 truncate">
                                                {{ entry.name }}
                                            </div>
                                            <div class="ml-2 flex-shrink-0 flex">
                                            <span v-if="false" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Geöffnet
                                            </span>
                                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
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