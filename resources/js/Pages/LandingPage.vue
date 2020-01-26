<template>

    <div class="bg-white">

        <div class="bg-white flex flex-col w-full relative">

            <div class="absolute inset-x-0 top-0 z-0 text-gray-200 dark:text-gray-700">
                <div class="">
                    <svg class="hidden sm:block w-full" style="margin-top: -170px;" viewBox="0 0 1440 600" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">
                        <path d="M0 0h1440v514.7L1320 536c-120 21.7-360 63.7-600 64-240-.3-480-42.3-600-64L0 514.7V0z" fill="currentColor" />
                    </svg>
                    <svg class="block sm:hidden w-full" style="" viewBox="0 0 1440 600" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">
                        <path d="M0 0h1440v514.7L1320 536c-120 21.7-360 63.7-600 64-240-.3-480-42.3-600-64L0 514.7V0z" fill="currentColor" />
                    </svg>
                </div>
            </div>

            <div class="absolute inset-x-0 top-0 overflow-x-hidden">
                <div class="relative px-3 py-3 md:px-4 md:py-4">
                    <div class="w-full md:max-w-6xl md:mx-auto md:flex md:items-center md:justify-between">

                        <div>
                            <a href="#" class="inline-block py-1 md:py-2 text-2xl font-bold text-gray-800 dark:text-white">Mein Moers</a>
                        </div>

<!--                    <div>-->
<!--                        <div class="hidden md:block">-->
<!--                            <a href="#"-->
<!--                               class="inline-block py-1 md:py-4 text-gray-600 mr-6 font-bold">-->
<!--                                How it Works-->
<!--                            </a>-->
<!--                            <a href="#"-->
<!--                               class="inline-block py-1 md:py-4 text-gray-500 hover:text-gray-600 mr-6">-->
<!--                                Solutions-->
<!--                            </a>-->

<!--                            <a href="#" class="inline-block py-1 md:py-4 text-gray-500 hover:text-gray-600 mr-6">-->
<!--                                Pricing-->
<!--                            </a>-->
<!--                            <a href="#"-->
<!--                               class="inline-block py-1 md:py-4 text-gray-500 hover:text-gray-600 mr-6">-->
<!--                                Offene Daten?-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->

                        <div class="hidden md:block">
                            <inertia-link :href="route('dashboard')"
                                          class="inline-block py-1 md:py-4 mr-6 text-gray-500 hover:text-gray-600 dark:text-gray-600">
                                Zum Portal
                            </inertia-link>
                            <a href="https://apps.apple.com/de/app/mein-moers/id1305862555?mt=8" target="_blank"
                                          class="inline-block py-2 px-4 text-gray-700 rounded-lg bg-white hover:bg-gray-100 dark:bg-yellow-500 dark:text-gray-900 dark-hover:bg-yellow-600">
                                Herunterladen
                            </a>
                        </div>
                    </div>
                    <div class="px-4 pt-16 pb-10">
                        <div class="relative w-full md:max-w-2xl md:mx-auto text-center">

                            <div class="px-4 md:hidden pb-4">
                                <img src="img/header.png" alt="Mein Moers App" />
                            </div>

                            <h1 class="mb-6 font-bold text-xl sm:text-2xl md:text-5xl leading-tight text-gray-700 dark:text-white">
                                Digitale Bürgerinformation auf Basis von <span class="text-red-500 dark:text-yellow-500">offenen Daten</span>
                            </h1>

                            <p class="md:text-xl md:px-18 leading-relaxed text-gray-600 dark:text-white">
                                Geschäfte, Parkplätze, 360° Panoramen, Veranstaltungen, aktuelle Kraftstoffpreise, Abfallkalender und vieles mehr!
                            </p>

                            <a href="https://apps.apple.com/de/app/mein-moers/id1305862555?mt=8" class="block mx-auto" target="_blank" style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/de-de/badge-lrg.svg?releaseDate=2018-02-19&kind=iossoftware&bubble=ios_apps) no-repeat; width:135px; height:40px;" />

                            <!-- Circles -->
                            <div class="hidden md:block h-32 w-32 rounded-full absolute right-0 bottom-0 -mb-64 -mr-88 bg-gray-600"></div>
                            <div class="hidden md:block h-5 w-5 rounded-full absolute top-0 right-0 -mr-40 mt-32 bg-red-500 dark:bg-yellow-500"></div>
                        </div>
                    </div>
                    <div>
                        <div class="max-w-5xl mx-auto relative z-20 hidden md:block">

                            <img src="img/header.png" alt="Mein Moers App" />

                            <div class="h-20 w-20 rounded-full absolute top-0 left-0 -ml-16 -mt-16 bg-red-500 dark:bg-yellow-500"
                                 style="z-index: -1;">
                            </div>

                            <div class="h-5 w-5 rounded-full absolute top-0 left-0 -ml-32 mt-12 bg-gray-500"
                                 style="z-index: -1;">
                            </div>

                        </div>
                    </div>
                    <p class="text-center p-4 text-gray-600 mt-10">
                        Ein Projekt von
                        <a class="border-b text-blue-500 dark:text-yellow-500 dark:border-yellow-500"
                           href="https://lambdadigamma.com/"
                           target="_blank">
                            Lennart Fischer.
                        </a>
                    </p>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
    import Navigation from "../Shared/Navigation";

    export default {
        name: "LandingPage",
        components: {Navigation}
    }
</script>

<style scoped>

</style>