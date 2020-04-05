<template>

    <div class="lg:w-1/2">
        <Header :href="route('polls.index')" previous-title="Abstimmungen">
            Details
        </Header>

        <div class="flex flex-row my-3" v-if="nextPoll && poll.results !== null">
            <inertia-link :href="route('polls.show', nextPoll.id)" class="block px-3 py-2 text-base font-semibold rounded-lg dark:bg-yellow-500 dark:text-black">
                Zur nächsten Abstimmung
            </inertia-link>
        </div>


        <div class="p-3 mb-6 rounded-lg shadow-lg dark:bg-gray-700">
            <PollVote v-if="poll.results === null" :poll='poll'>

            </PollVote>
            <div v-else>
                <h1 class="text-xl font-bold md:text-3xl dark:text-white">{{ poll.question }}</h1>
                <p class="text-base dark:text-white">{{ poll.description }}</p>

                <h2 class="mt-3 mb-0 text-lg font-semibold dark:text-white">Ergebnisse:</h2>
                <p class="mt-2 font-medium dark:text-white">
                    Die Ergebnisse werden auf Wunsch bis auf weiteres versteckt gehalten.
                </p>

<!--                <PollResult :results="this.poll.results">-->

<!--                </PollResult>-->
            </div>
        </div>


    </div>

</template>

<script>
    import Header from "@/Shared/Admin/Header";
    import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral";
    import PollVote from "@/components/PollVote";
    import PollResult from "@/Shared/PollResult";
    export default {
        name: "Show",
        components: {PollResult, PollVote, Header},
        layout: LayoutGeneral,
        props: {
            poll: Object,
            nextPoll: Object
        },
        created() {
            this.$root.$emit('newTitle', 'Details')
        }
    }
</script>

<style scoped>

</style>