<template>

    <div>
        <div class="relative pb-2/3">
            <button class="absolute top-0 left-0 z-50 p-2 mt-4 ml-4 rounded-full overflow-hidden bg-gray-300">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6 text-white">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <img class="absolute object-cover w-full h-full"
                 src="https://images.unsplash.com/photo-1464869372688-a93d806be852?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" />
        </div>

        <div class="p-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-900">{{ entry.name }}</h1>
            <span class="text-base font-medium text-gray-600">{{ entry.street }} {{ entry.house_number }}</span>
        </div>

        <div class="p-4 md:py-6 border-b border-gray-200">

            <PrimaryButton size="lg" block>
                Route
            </PrimaryButton>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="col-span-1">
                    <WhiteButton size="lg" block :disabled="!entry.phone">
                        Anrufen
                    </WhiteButton>
                </div>
                <div class="col-span-1">
                    <WhiteButton size="lg" block :disabled="!entry.url">
                        Webseite
                    </WhiteButton>
                </div>
            </div>

        </div>

        <div class="p-4 border-b border-gray-200">

            <div class="text-base text-gray-700">
                <h2 class="text-base font-medium text-gray-900">Öffnungszeiten</h2>
                <div class="grid grid-cols-3 gap-4 mt-2">
                    <div class="col-span-1">
                        Montag
                    </div>
                    <div class="col-span-2">
                        {{ entry.monday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Dienstag
                    </div>
                    <div class="col-span-2">
                        {{ entry.tuesday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Mittwoch
                    </div>
                    <div class="col-span-2">
                        {{ entry.wednesday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Donnerstag
                    </div>
                    <div class="col-span-2">
                        {{ entry.thursday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Freitag
                    </div>
                    <div class="col-span-2">
                        {{ entry.friday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Samstag
                    </div>
                    <div class="col-span-2">
                        {{ entry.saturday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Sonntag
                    </div>
                    <div class="col-span-2">
                        {{ entry.sunday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        Sonstiges
                    </div>
                    <div class="col-span-2">
                        {{ entry.other }}
                    </div>
                </div>

            </div>
        </div>




        <div class="p-4 border-b border-gray-200">

            <h2 class="text-base font-medium text-gray-900">Adresse</h2>

            <div class="text-gray-700">
                <span>
                    Neustraße 33b
                </span>

            </div>

        </div>

        <div class="p-4 border-b border-gray-200">

            <h2 class="text-base font-medium text-gray-900">Schlagworte</h2>
            <div class="mb-2 flex flex-wrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    Café
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    Draußen
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    barrierefrei
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    Kinderecke
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    WLAN
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    Wickeltisch
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2">
                    Sky
                </span>
            </div>
        </div>
    </div>

</template>

<script>
    import PrimaryButton from "../UI/PrimaryButton";
    import WhiteButton from "../UI/WhiteButton";
    export default {
        name: "EntryDetail",
        components: {WhiteButton, PrimaryButton},
        props: {
            entry: Object
        }
    }
</script>

<style scoped>

</style>