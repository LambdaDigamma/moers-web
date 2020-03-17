<template>

    <div>
        <div class="mt-4 md:mt-8 pb-48">

            <div class="bg-gray-200 overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900">
                        Hilf mit, die Krise gemeinsam zu bewältigen!
                    </h2>
                    <p class="my-2">Ab heute bieten wir eine Platform an, um als Moerserinnen und Moerser zusammen zu stehen und einander zu helfen!</p>
                    <p class="mb-2">
                        In der aktuellen Zeit halten sich viele Menschen in freiwilliger oder angeordneter Quarantäne auf.
                        Auch andere Menschen und besonders gefährdete Gruppen versuchen, den Kontakt mit anderen Menschen zu beschränken.
                        Wenn du diesen Menschen helfen willst, kannst du deine Hilfe anbieten oder Aufgaben wahrnehmen.
                        Falls du Hilfe brauchst, kannst du sie hier suchen und finden!
                    </p>
                    <div class="mt-5 flex flex-col md:flex-row">
                        <span class="inline-flex rounded-md shadow-sm">
                            <inertia-link :href="route('help.serve')" class="inline-flex w-full items-center px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-500 hover:bg-green-400 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700 transition ease-in-out duration-150">
                                <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                                </svg>
                                Ich möchte helfen!
                            </inertia-link>
                        </span>
                        <span class="ml-0 mt-4 md:ml-4 md:mt-0 inline-flex rounded-md shadow-sm">
                            <inertia-link :href="route('help.need')" class="inline-flex w-full items-center px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150">
                                <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                </svg>
                                Ich benötige Hilfe!
                            </inertia-link>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 bg-gray-200 overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900">
                        Wichtige Hinweise
                    </h2>

                    <div class="mt-6 flex flex-col md:flex-row">
                        <div class="w-full md:w-1/3 flex flex-col text-center items-center">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-12 h-12 text-gray-900">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <h1 class="text-xl leading-9 font-bold text-gray-900 sm:leading-10 text-center">
                                Hilf lokal!
                            </h1>
                            <p class="text-gray-800">
                                Nachbarschaftshilfe ist in dieser Zeit sehr wichtig.
                            </p>
                        </div>
                        <div class="mt-3 md:mt-0 w-full md:w-1/3 flex flex-col text-center items-center">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-12 h-12 text-gray-900">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                            </svg>
                            <h1 class="text-xl leading-9 font-bold text-gray-900 sm:leading-10 text-center">
                                Hilf kontinuierlich!
                            </h1>
                            <p class="text-gray-800">
                                Suche dir jemanden und hilf nur ihm.
                            </p>
                        </div>
                        <div class="mt-3 md:mt-0 w-full md:w-1/3 flex flex-col text-center items-center">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-12 h-12 text-gray-900">
                                <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                            </svg>
                            <h1 class="text-xl leading-9 font-bold text-gray-900 sm:leading-10 text-center">
                                Hilf in Distanz!
                            </h1>
                            <p class="text-gray-800">
                                Meidet bei der Hilfe falls möglich und im Sinne der Hilfeleistung erforderlich den direkten Kontakt.
                            </p>
                        </div>
                    </div>
                    <p class="mt-4 md:mt-6 text-gray-900 text-center font-medium">
                        Halte dich bei allen Hilfeleistungen bitte an die Empfehlungen und Vorschriften des
                        <a href="https://www.infektionsschutz.de/coronavirus-sars-cov-2.html" class="font-semibold" target="_blank">BZgA</a>
                        und des
                        <a href="https://www.kreis-wesel.de/de/themen/coronavirus/" class="font-semibold" target="_blank">lokalen Gesundheitsamts</a>!
                    </p>
                </div>
            </div>

            <div class="mt-4 bg-gray-200 overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-2xl leading-9 font-bold text-gray-900 sm:text-2xl sm:leading-10">
                        Häufig gestellte Fragen
                    </h2>
                    <div class="mt-6 border-t-2 border-gray-300 pt-6">
                        <dl>
                            <div class="md:grid md:grid-cols-12 md:gap-8">
                                <dt class="text-base leading-6 font-medium text-gray-900 md:col-span-5">
                                    Ich möchte helfen! Wie funktioniert das?
                                </dt>
                                <dd class="mt-2 md:mt-0 md:col-span-7">
                                    <p class="text-base leading-6 text-gray-500">
                                        <inertia-link :href="route('help.serve')" class="hover:underline text-gray-600 font-medium">Hier</inertia-link> kannst du sehen, welche Hilfe gebraucht wird und Kontakt mit den Hilfesuchenden aufnehmen.
                                        Zusätzlich kannst du auch informiert werden, wenn Menschen in deinem Stadtteil in Zukunft Hilfe suchen.
                                    </p>
                                </dd>
                            </div>
                            <div class="mt-8 border-t border-gray-300 pt-6 md:grid md:grid-cols-12 md:gap-8">
                                <dt class="text-base leading-6 font-medium text-gray-900 md:col-span-5">
                                    Ich benötige Hilfe! Aber wie?
                                </dt>
                                <dd class="mt-2 md:mt-0 md:col-span-7">
                                    <p class="text-base leading-6 text-gray-500">
                                        <inertia-link :href="route('help.need')" class="hover:underline text-gray-600 font-medium">Hier</inertia-link> kannst du eintragen, dass du Hilfe benötigst.
                                        Wähle einfach deinen Stadtteil aus und beschreibe kurz, wobei zu Hilfe benötigst.
                                    </p>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

<!--            <div v-if="ownHelpRequests !== null && ownHelpRequests.length !== 0" class="mt-6">-->

<!--                <h2 class="text-3xl font-bold leading-tight text-gray-900">-->
<!--                    Du suchst Hilfe:-->
<!--                </h2>-->

<!--                <ul>-->
<!--                    <li v-for="(request, index) in ownHelpRequests" :key="index" class="mt-6">-->
<!--                        <HelpItem :request="request" />-->
<!--                    </li>-->
<!--                </ul>-->

<!--            </div>-->

<!--            <div v-if="userActiveHelpRequests !== null && userActiveHelpRequests.length !== 0" class="mt-6">-->

<!--                <h2 class="text-3xl font-bold leading-tight text-gray-900">-->
<!--                    Du hilfst:-->
<!--                </h2>-->

<!--                <ul>-->
<!--                    <li v-for="(request, index) in userActiveHelpRequests" :key="index" class="mt-6">-->
<!--                        <HelpItem :request="request" />-->
<!--                    </li>-->
<!--                </ul>-->

<!--            </div>-->

<!--            <div v-if="openHelpRequests !== null && openHelpRequests.length !== 0" class="mt-6">-->

<!--                <h2 class="text-3xl font-bold leading-tight text-gray-900">-->
<!--                    Jemand sucht Hilfe:-->
<!--                </h2>-->

<!--                <ul>-->
<!--                    <li v-for="(request, index) in openHelpRequests" :key="index" class="mt-6">-->
<!--                        <HelpItem :request="request" />-->
<!--                    </li>-->
<!--                </ul>-->

<!--            </div>-->

        </div>

    </div>


</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import HelpItem from "../../Shared/Help/HelpItem";

    export default {
        name: "Index",
        components: {HelpItem},
        layout: LayoutGeneral,
        props: {

        }
    }
</script>

<style scoped>

</style>