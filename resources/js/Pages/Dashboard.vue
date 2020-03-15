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
                        <PollItem :poll="poll" />
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