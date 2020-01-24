<template>

    <div class="lg:w-1/2">
        <Header :href="route('polls.index')" previous-title="Abstimmungen">
            Details
        </Header>

        <div class="p-3 rounded-lg dark:bg-gray-700">
            <PollVote v-if="poll.results === null" :poll='poll'>

            </PollVote>
            <PollResult v-else :results="this.poll.results">

            </PollResult>
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