<template>

    <div class="lg:w-1/2">
        <Header :href="route('polls.index')" previous-title="Abstimmungen">
            Details
        </Header>

        <div class="p-3 rounded-lg shadow-lg dark:bg-gray-700 mb-6">
            <PollVote v-if="poll.results === null" :poll='poll'>

            </PollVote>
            <div v-else>
                <h1 class="font-bold text-xl md:text-3xl dark:text-white">{{ poll.question }}</h1>
                <p class="text-base dark:text-white">{{ poll.description }}</p>
                <PollResult :results="this.poll.results">

                </PollResult>
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
            poll: Object
        },
        created() {
            this.$root.$emit('newTitle', 'Details')
        }
    }
</script>

<style scoped>

</style>