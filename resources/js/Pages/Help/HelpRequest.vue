<template>

    <div>

        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Kontakt
                    <span v-if="request.helper">
                        zu
                        <span v-if="isCreator">{{ request.helper.name }}</span>
                        <span v-else>{{ request.creator.name }}</span>
                    </span>

                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Biete deine Hilfe an, nimm Kontakt auf und kläre Genaueres.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">

                <div id="start-contact-container" v-if="!isCreator && request.served_on === null">
                    <inertia-link :href="route('help.request.accept', request.id)" method="PUT" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-blue-200 transition ease-in-out duration-150">
                        Nimm Kontakt auf
                    </inertia-link>
                    <p class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                        Wenn du den Kontakt aufnimmst, kann der Hilfesuchende deinen Namen sehen und dir schreiben.
                        Danach wird diese Hilfesuche nicht mehr öffentlich angezeigt und ihr beide befindet euch in einem privaten Raum.
                    </p>
                </div>

            </div>
        </div>

        <div class="mt-6 bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Informationen zur Hilfesuche
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Details und weitere Informationen zur Hilfesuche. Biete hier deine Hilfe an.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-0">
                <dl>
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5" v-if="request.creator">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Hilfesuchende/r
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ request.creator.name }}
                        </dd>
                    </div>
                    <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Stadtteil
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ request.quarter.name }}
                        </dd>
                    </div>
                    <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Postleitzahl
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ request.quarter.postcode }}
                        </dd>
                    </div>
                    <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Eingestellt am
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ request.created_at | moment("dddd, Do MMM [um] H:mm") }}
                        </dd>
                    </div>
                    <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            Beschreibung der Hilfesuche
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ request.request }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg" v-if="isCreator">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Administration
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Lösche die Hilfesuche und alle damit verbundenen Unterhaltungen.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div>
                    <inertia-link :href="route('help.request.delete', request.id)" method="DELETE" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-50 focus:outline-none focus:border-red-300 focus:shadow-outline-red active:bg-red-200 transition ease-in-out duration-150">
                        Ziehe die Hilfesuche zurück
                    </inertia-link>
                    <p class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                        Wenn du diese Hilfesuche zurück ziehst, wird der Helfer gegebenenfalls darüber informiert und alle Daten werden gelöscht.
                    </p>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";

    export default {
        name: "HelpRequest",
        layout: LayoutGeneral,
        props: {
            request: Object,
            isCreator: Boolean
        },
    }
</script>

<style scoped>

</style>