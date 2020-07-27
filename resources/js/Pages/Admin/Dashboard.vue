<template>

    <div>
        <header class="py-10">
            <h1 class="text-3xl leading-9 font-bold">
                Dashboard
            </h1>
        </header>
        <main>
            <h3 class="text-lg leading-6 font-medium text-gray-600">
                Allgemeine Statistiken
            </h3>
            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
<!--                <div class="bg-white overflow-hidden shadow rounded-lg">-->
<!--                    <div class="px-4 py-5 sm:p-6">-->
<!--                        <div class="flex items-center">-->
<!--                            <div class="flex-shrink-0 bg-gray-800 rounded-md p-3">-->
<!--                                <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                            <div class="ml-5 w-0 flex-1">-->
<!--                                <dl>-->
<!--                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">-->
<!--                                        Benutzer gesamt-->
<!--                                    </dt>-->
<!--                                    <dd class="flex items-baseline">-->
<!--                                        <div class="text-2xl leading-8 font-semibold text-gray-900">-->
<!--                                            {{ countUsers }}-->
<!--                                        </div>-->
<!--                                    </dd>-->
<!--                                </dl>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="bg-gray-100 px-4 py-4 sm:px-6">-->
<!--                        <div class="text-sm leading-5">-->
<!--                            <inertia-link href="#" class="font-medium text-gray-800 hover:text-gray-900 transition ease-in-out duration-150">-->
<!--                                Alle ansehen-->
<!--                            </inertia-link>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-800 rounded-md p-3">
                                <svg class="h-6 w-6 text-white"  stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Organisationen gesamt
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                                            {{ numberOfOrganisations }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-4 py-4 sm:px-6">
                        <div class="text-sm leading-5">
                            <inertia-link :href="route('admin.organisations.index')" class="font-medium text-gray-800 hover:text-gray-900 transition ease-in-out duration-150">
                                Alle ansehen
                            </inertia-link>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-800 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Einträge gesamt
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                                            {{ numberOfEntries }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-4 py-4 sm:px-6">
                        <div class="text-sm leading-5">
                            <inertia-link :href="route('admin.entries.index')" class="font-medium text-gray-800 hover:text-gray-900 transition ease-in-out duration-150">
                                Alle ansehen
                            </inertia-link>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-800 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Veranstaltungen gesamt
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                                            {{ numberOfEvents }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-4 py-4 sm:px-6">
                        <div class="text-sm leading-5">
                            <inertia-link :href="route('admin.events.index')" class="font-medium text-gray-800 hover:text-gray-900 transition ease-in-out duration-150">
                                Alle ansehen
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

</template>

<script>
    import Navigation from "../../Shared/Navigation";
    import LayoutAdmin from "../../Shared/LayoutAdmin";
    export default {
        name: "Dashboard",
        components: {Navigation},
        layout: LayoutAdmin,
        props: {
            numberOfEntries: Number,
            numberOfOrganisations: Number,
            numberOfEvents: Number
        }
    }
</script>

<style scoped>

</style>