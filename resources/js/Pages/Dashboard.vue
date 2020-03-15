<template>

    <div>

        <header>
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Übersicht
                </h2>
            </div>
        </header>

        <div class="mt-4">

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Offene Abstimmungen
                    </h3>
                </div>
                <ul>
                    <li class="border-t border-gray-200" v-for="poll in unansweredPolls">
                        <inertia-link :href="route('polls.show', poll.id)" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                        <div>
                                            <div class="text-sm leading-5 font-medium truncate">{{ poll.question }}</div>
                                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                <span class="truncate"
                                                      v-if="poll.group && poll.group.organisation">
                                                        {{ poll.group.organisation.name }} • {{ poll.group.name }}
                                                </span>
                                                <span class="truncate" v-else>
                                                    Unbekannte Gruppe
                                                </span>
                                            </div>
                                        </div>
                                        <div class="hidden md:block">
                                            <div>
                                                <div class="text-sm leading-5 text-gray-900">
                                                    <span v-if="poll.results === null">Kein Benutzer hat abgestimmt.</span>
                                                    <span v-else-if="poll.results.total === 1">
                                                        {{ poll.results.total }} Benutzer hat abgestimmt.
                                                    </span>
                                                    <span v-else>
                                                        {{ poll.results.total }} Benutzer haben abgestimmt.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </inertia-link>
                    </li>
                </ul>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                    <span class="inline-flex rounded-md shadow-sm">
                        <inertia-link :href="route('polls.index')" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                            Alle ansehen
                        </inertia-link>
                    </span>
                </div>
            </div>


        </div>

    </div>

</template>

<script>
    import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral";
    import Icon from "../Shared/Icon";
    import PollItem from "../Shared/Polls/PollItem";

    export default {
        name: "Dashboard",
        components: {PollItem, Icon},
        layout: LayoutGeneral,
        props: {
            unansweredPolls: Array,
            answeredPolls: Array
        },
        created() {
            this.$root.$emit('newTitle', 'Übersicht')
        }
    }
</script>

<style scoped>

</style>