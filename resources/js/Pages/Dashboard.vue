<template>

    <div>

        <h1 class="mt-2 font-bold text-4xl dark:text-white">Übersicht</h1>

        <div class="w-full flex flex-wrap">
            <div class="w-full sm:w-1/2 lg:w-1/3 sm:pr-2">
                <div class="rounded-lg">
                    <div class="flex items-center px-3 py-1 pt-2 rounded-t-lg dark:bg-gray-900">
                        <h2 class="font-semibold text-2xl dark:text-white">
                            Unbeantwortete Abstimmungen
                        </h2>
                    </div>
                    <div class="dark:bg-gray-700 rounded-b-lg">
                        <inertia-link v-for="poll in unansweredPolls"
                                      :key="poll.id" :href="route('polls.show', poll.id)"
                                      class="block p-2 px-3 border-b-2 last:border-b-0 dark:border-gray-900 hover:no-underline">
                            <h3 class="text-lg font-medium text-white">
                                {{ poll.question }} <span v-if="poll.is_closed" class="font-medium text-white">(beendet)</span>
                            </h3>
                            <span class="mb-1 text-xs font-semibold uppercase leading-normal tracking-normal dark:text-yellow-500"
                                v-if="poll.group && poll.group.organisation">
                                {{ poll.group.organisation.name }} • {{ poll.group.name }}
                            </span>
                            <span class="text-xs font-semibold uppercase leading-relaxed tracking-normal dark:text-yellow-500" v-else>
                                Unbekannte Gruppe
                            </span>
                        </inertia-link>
                    </div>
                    <div class="px-3 py-2 rounded-t-lg dark:bg-gray-900">
                        <inertia-link :href="route('polls.index')" class="flex items-center font-normal text-base dark:text-white dark-hover:text-yellow-500">
                            <span>Alle anzeigen</span>
                            <icon name="cheveron-right" class="h-4 w-4 ml-0 mt-1 dark:fill-current"></icon>
                        </inertia-link>
                    </div>
                </div>

            </div>
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <div class="rounded-lg">
                    <div class="flex items-center px-3 py-1 pt-2 rounded-t-lg dark:bg-gray-900">
                        <h2 class="font-semibold text-2xl dark:text-white">
                            Beantwortete Abstimmungen
                        </h2>
                        <icon name="cheveron-right" class="h-5 w-5 ml-0 mb-1 dark:fill-white"></icon>
                    </div>
                    <div class="dark:bg-gray-700 rounded-b-lg">
                        <div v-for="poll in answeredPolls" :key="poll.id" class="p-2 px-3">
                            <h3 class="text-lg font-medium text-white">{{ poll.question }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral";
    import Icon from "../Shared/Icon";

    export default {
        name: "Dashboard",
        components: {Icon},
        layout: LayoutGeneral,
        props: {
            unansweredPolls: Array,
            answeredPolls: Array
        }
    }
</script>

<style scoped>

</style>