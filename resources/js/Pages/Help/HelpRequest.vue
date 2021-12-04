<template>
    <div class="pb-48">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Kontakt
                    <span v-if="request.helper">
                        zu
                        <span v-if="isCreator">{{
                            request.helper.first_name
                        }}</span>
                        <span v-else>{{ request.creator.first_name }}</span>
                    </span>
                </h3>
                <p class="max-w-2xl mt-1 text-sm leading-5 text-gray-500">
                    Nehmt Kontakt auf und tauscht eure Kontaktdaten aus.
                </p>
            </div>
            <div
                class="px-4 py-5 sm:p-6"
                v-if="!isCreator && request.served_on === null"
            >
                <div id="start-contact-container">
                    <inertia-link
                        :href="route('help.request.accept', request.id)"
                        method="PUT"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-blue-700 transition duration-150 ease-in-out bg-blue-100 border border-transparent rounded-md hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-blue-200"
                    >
                        Nimm Kontakt auf
                    </inertia-link>
                    <p class="max-w-xl mt-2 text-sm leading-5 text-gray-500">
                        Wenn du den Kontakt aufnimmst, kann der Hilfesuchende
                        deinen Namen sehen und dir schreiben. Danach wird diese
                        Hilfesuche nicht mehr öffentlich angezeigt und ihr beide
                        befindet euch in einem privaten Raum.
                    </p>
                </div>
            </div>
            <ChatBox
                v-else-if="request.served_on !== null"
                :conversation="request.conversation"
                :messages="messages"
                @send="sendMessage"
            >
            </ChatBox>
            <div class="px-4 py-5 sm:p-6" v-else>
                <p class="max-w-xl text-sm leading-5 text-gray-500">
                    Warte bis jemand dich kontaktiert.
                </p>
            </div>
        </div>
        <div
            class="flex flex-row items-center mt-2 ml-2 text-sm text-gray-400"
            v-if="request.served_on !== null"
        >
            <svg viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                <path
                    fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                />
            </svg>
            <p class="ml-2 sm:ml-1">
                Lade die Seite neu, falls es beim Chat gibt. Bei Fragen melde
                dich
                <a href="mailto:info@lambdadigamma.com" class="text-gray-600"
                    >hier.</a
                >
            </p>
        </div>

        <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Informationen zur Hilfesuche
                </h3>
                <p class="max-w-2xl mt-1 text-sm leading-5 text-gray-500">
                    Details und weitere Informationen zur Hilfesuche. Biete hier
                    deine Hilfe an.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-0">
                <dl>
                    <div
                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5"
                        v-if="request.creator"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Hilfesuchende/r
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ request.creator.first_name }}
                        </dd>
                    </div>
                    <div
                        class="sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                        :class="{ 'mt-8': request.creator }"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Stadtteil
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ request.quarter.name }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Postleitzahl
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ request.quarter.postcode }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Eingestellt am
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{
                                request.created_at
                                    | moment("dddd, Do MMM [um] HH:mm")
                            }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Beschreibung der Hilfesuche
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ request.request }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div
            class="mt-6 overflow-hidden bg-white shadow sm:rounded-lg"
            v-if="isCreator"
        >
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Aktionen
                </h3>
                <p class="max-w-2xl mt-1 text-sm leading-5 text-gray-500">
                    Führe Aktionen für diese Hilfeleistung durch.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div v-if="request.served_on !== null">
                    <inertia-link
                        :href="route('help.request.done', request.id)"
                        method="POST"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-green-700 transition duration-150 ease-in-out bg-green-100 border border-transparent rounded-md hover:bg-green-50 focus:outline-none focus:border-green-300 focus:ring-green active:bg-green-200"
                    >
                        Ich habe einen Helfer gefunden
                    </inertia-link>
                    <p class="max-w-xl mt-2 text-sm leading-5 text-gray-500">
                        Wenn jemand dir geholfen hat, kannst du hier die
                        Hilfesuche schließen. Dabei werden alle Informationen
                        komplett gelöscht und der Helfende wird darüber
                        informiert.
                    </p>
                </div>
                <div :class="{ 'mt-6': request.served_on !== null }">
                    <inertia-link
                        :href="route('help.request.delete', request.id)"
                        method="DELETE"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-red-700 transition duration-150 ease-in-out bg-red-100 border border-transparent rounded-md hover:bg-red-50 focus:outline-none focus:border-red-300 focus:ring-red active:bg-red-200"
                    >
                        Ziehe die Hilfesuche zurück
                    </inertia-link>
                    <p class="max-w-xl mt-2 text-sm leading-5 text-gray-500">
                        Wenn du diese Hilfesuche zurück ziehst, wird der Helfer
                        gegebenenfalls darüber informiert und alle Daten werden
                        gelöscht.
                    </p>
                </div>
            </div>
        </div>

        <div
            class="mt-6 overflow-hidden bg-white shadow sm:rounded-lg"
            v-if="isHelper"
        >
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Aktionen
                </h3>
                <p class="max-w-2xl mt-1 text-sm leading-5 text-gray-500">
                    Führe Aktionen für diese Hilfeleistung durch.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div v-if="request.served_on !== null">
                    <inertia-link
                        :href="route('help.request.quit', request.id)"
                        method="POST"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-red-700 transition duration-150 ease-in-out bg-red-100 border border-transparent rounded-md hover:bg-red-50 focus:outline-none focus:border-red-300 focus:ring-red active:bg-red-200"
                    >
                        Wieder austreten
                    </inertia-link>
                    <p class="max-w-xl mt-2 text-sm leading-5 text-gray-500">
                        Wenn du austrittst, wird die Hilfesuche wieder jedem
                        angezeigt und kann von jemand anderem ausgeführt werden.
                        Die Konversation und alle verbundenen Nachrichten werden
                        vollständig gelöscht.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral.vue";
import ChatBox from "@/Shared/UI/ChatBox.vue";

export default {
    name: "HelpRequest",
    components: { ChatBox },
    layout: LayoutGeneral,
    props: {
        request: Object,
        isCreator: Boolean,
        isHelper: Boolean,
        messages: Array,
    },
    methods: {
        sendMessage(message) {
            this.$inertia.post(
                this.route("help.request.sendMessage", this.request.id),
                { content: message },
                {
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                    only: ["messages"],
                }
            );
        },
    },
    mounted() {
        Echo.private("conversation." + this.request.conversation.id).listen(
            ".user.joined",
            (e) => {
                this.$inertia.reload(
                    this.route("help.request.show", this.request.id),
                    {
                        replace: false,
                        preserveState: true,
                        preserveScroll: true,
                        only: ["messages"],
                    }
                );
            }
        );
    },
};
</script>

<style scoped></style>
