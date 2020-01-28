<template>

    <div>

        <h1 class="mt-2 font-semibold text-2xl md:text-4xl dark:text-white hidden md:block">Übersicht</h1>

        <div class="w-full flex flex-wrap">
            <div class="w-full sm:w-1/2 lg:w-1/3 sm:pr-2">
                <div class="rounded-lg">
                    <div class="flex items-center px-3 py-1 pt-2 rounded-t-lg dark:bg-gray-900">
                        <h2 class="font-semibold text-lg md:text-2xl dark:text-white">
                            Unbeantwortete Abstimmungen
                        </h2>
                    </div>
                    <div v-if="unansweredPolls.length === 0" class="block p-2 px-3 dark:border-gray-900 text-sm dark:text-gray-600">
                        Keine unbeantworteten Abstimmungen.
                    </div>
                    <div class="dark:bg-gray-700 rounded-b-lg">
                        <inertia-link v-for="poll in unansweredPolls"
                                      :key="poll.id" :href="route('polls.show', poll.id)"
                                      class="block p-2 px-3 border-b-2 last:border-b-0 dark:border-gray-900 hover:no-underline">
                            <PollItem :poll="poll" />
                        </inertia-link>
                    </div>
                    <div class="px-3 py-2 rounded-b-lg dark:bg-gray-900">
                        <inertia-link :href="route('polls.index')" class="flex items-center font-normal text-sm dark:text-white dark-hover:text-yellow-500">
                            <span>Alle anzeigen</span>
                            <icon name="cheveron-right" class="h-4 w-4 ml-0 dark:fill-current"></icon>
                        </inertia-link>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/3 sm:pr-2 pt-3 md:pt-0">
                <div class="rounded-lg">
                    <div class="flex items-center px-3 py-1 pt-2 rounded-t-lg dark:bg-gray-900">
                        <h2 class="font-semibold text-lg md:text-2xl dark:text-white">
                            Beantwortete Abstimmungen
                        </h2>
                    </div>
                    <div v-if="answeredPolls.length === 0" class="block p-2 px-3 dark:border-gray-900 text-sm dark:text-gray-600">
                        Keine beantworteten Abstimmungen.
                    </div>
                    <div class="dark:bg-gray-700 rounded-b-lg">
                        <inertia-link v-for="poll in answeredPolls"
                                      :key="poll.id" :href="route('polls.show', poll.id)"
                                      class="block p-2 px-3 border-b-2 last:border-b-0 dark:border-gray-900 hover:no-underline">
                            <PollItem :poll="poll" />
                        </inertia-link>
                    </div>
                    <div class="px-3 py-2 rounded-b-lg dark:bg-gray-900">
                        <inertia-link :href="route('polls.index.answered')" class="flex items-center font-normal text-sm dark:text-white dark-hover:text-yellow-500">
                            <span>Alle anzeigen</span>
                            <icon name="cheveron-right" class="h-4 w-4 ml-0 dark:fill-current"></icon>
                        </inertia-link>
                    </div>
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