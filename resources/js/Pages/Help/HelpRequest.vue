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
            <div id="message-box" v-else-if="request.served_on !== null && request.conversation !== null">
                <div class="bg-gray-100 flex flex-col h-64">
                    <div class="overflow-y-auto py-5 px-4 sm:p-6" scroll-region id="scroll-container">
                        <div class="flex flex-row mb-3" v-for="message in messages" :class="{ 'justify-end' : message.sender_id === $page.auth.user.id }">
                            <div class="w-1/2 px-3 py-2 text-sm rounded-md" :class="[message.sender_id === $page.auth.user.id ? 'bg-blue-200' : 'bg-red-200' ]">
                                <p>{{ message.content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex px-4 py-2 sm:p-6 md:py-3 bg-white rounded-lg shadow">
                    <label for="search_field" class="sr-only">Nachricht eingeben</label>
                    <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                        <button class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <input id="search_field" @keydown.enter="sendMessage" v-model="form.message" class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm" placeholder="Nachricht eingeben" />
                    </div>
                    <button type="button" @click="sendMessage" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-blue-200 transition ease-in-out duration-150">
                        Senden
                    </button>
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6" v-else>
                <p class="max-w-xl text-sm leading-5 text-gray-500">
                    Warte bis jemand dich kontaktiert.
                </p>
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
            isCreator: Boolean,
            messages: Array
        },
        data() {
            return {
                form: {
                    message: null
                }
            }
        },
        methods: {
            sendMessage() {

                this.$inertia.post(this.route('help.request.sendMessage', this.request.id), { content: this.form.message }, {
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                    only: ['messages'],
                })

                this.form.message = null

            }
        },
        mounted() {

            if (this.request.conversation) {
                Echo.private('conversation.' + this.request.conversation.id)
                    .listen('.message.posted', (e) => {
                        this.messages.push(e.message)
                    });
            }

        },
        updated() {
            var container = this.$el.querySelector("#scroll-container");
            container.scrollTop = container.scrollHeight;
        }
    }
</script>

<style scoped>

</style>