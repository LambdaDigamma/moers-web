<template>

    <div class="pb-48">

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
            <div class="px-4 py-5 sm:p-6" v-if="!isCreator && request.served_on === null">
                <div id="start-contact-container" >
                    <inertia-link :href="route('help.request.accept', request.id)" method="PUT" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-blue-200 transition ease-in-out duration-150">
                        Nimm Kontakt auf
                    </inertia-link>
                    <p class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                        Wenn du den Kontakt aufnimmst, kann der Hilfesuchende deinen Namen sehen und dir schreiben.
                        Danach wird diese Hilfesuche nicht mehr öffentlich angezeigt und ihr beide befindet euch in einem privaten Raum.
                    </p>
                </div>
            </div>
            <ChatBox v-else-if="request.served_on !== null"
                     :conversation="request.conversation"
                     :messages="messages"
                     @send="sendMessage">

            </ChatBox>
            <div class="px-4 py-5 sm:p-6" v-else>
                <p class="max-w-xl text-sm leading-5 text-gray-500">
                    Warte bis jemand dich kontaktiert.
                </p>
            </div>
        </div>
        <div class="mt-2 flex flex-row items-center text-gray-400 text-sm" v-if="request.served_on !== null">
            <svg viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <p class="ml-2 sm:ml-1">Lade die Seite neu, falls es beim Chat gibt. Bei Fragen melde dich <a href="mailto:info@lambdadigamma.com" class="text-gray-600">hier.</a></p>
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
                    <div class="sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5" :class="{ 'mt-8' : request.creator }">
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
                    Aktionen
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Lösche die Hilfesuche und alle damit verbundenen Unterhaltungen.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div v-if="request.served_on !== null">
                    <inertia-link :href="route('help.request.done', request.id)"
                                  method="POST"
                                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-50 focus:outline-none focus:border-green-300 focus:shadow-outline-green active:bg-green-200 transition ease-in-out duration-150">
                        Die Hilfesuche wurde erledigt
                    </inertia-link>
                    <p class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                        Wenn jemand dir geholfen hat, kannst du hier die Hilfesuche schließen.
                        Dabei werden alle Informationen komplett gelöscht und der Helfende wird darüber informiert.
                    </p>
                </div>
                <div :class="{ 'mt-6' : request.served_on !== null }">
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
    import ChatBox from "../../Shared/UI/ChatBox";

    export default {
        name: "HelpRequest",
        components: {ChatBox},
        layout: LayoutGeneral,
        props: {
            request: Object,
            isCreator: Boolean,
            messages: Array
        },
        methods: {
            sendMessage(message) {

                this.$inertia.post(this.route('help.request.sendMessage', this.request.id), { content: message }, {
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                    only: ['messages'],
                })

            }
        },
        mounted() {
            
            Echo.private('conversation.' + this.request.conversation.id)
                .listen('.user.joined', (e) => {
                    this.$inertia.reload(this.route('help.request.show', this.request.id), {
                        replace: false,
                        preserveState: true,
                        preserveScroll: true,
                        only: ['messages'],
                    })
                });

        },
    }
</script>

<style scoped>

</style>