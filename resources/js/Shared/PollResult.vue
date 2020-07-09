<template>

    <div>
        <div v-if="this.results.total !== 0">
            <PollChart :chartData="chartData" :chartLabels="chartLabels"  />
            <div class="mt-4 rounded">
                <div class="flex align-items-center">
                    <p v-if="this.results.total === 1" class="m-0 font-semibold">
                        Eine Person hat schon abgestimmt.
                    </p>
                    <p v-else class="m-0 font-semibold">
                        {{ this.results.total }} Personen haben schon abgestimmt.
                    </p>
                </div>
                <h2 class="mt-3 mb-0 text-lg font-semibold dark:text-white">Ergebnisse:</h2>
                <div v-for="(vote, index) in this.results.votes" :key="index">
                    <div class="flex flex-row items-center justify-start">
                        <div class="w-32 px-2 py-1 mt-2 font-semibold text-center rounded sm:mt-0 dark:bg-yellow-500 dark:text-gray-900">Stimmen: {{ vote.votes }}</div>
                        <div class="mt-2 ml-2 font-medium text-center sm:text-left sm:mt-0">{{ vote.name }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-lg font-medium leading-6 text-gray-900">
            Noch keine Ergebnisse verfügbar.
        </div>
    </div>

</template>

<script>
    import PollChart from "../components/Poll/PollChart";
    export default {
        name: "PollResult",
        components: {PollChart},
        props: {
            results: Object,
            votes: Array
        },
        data() {
            return {
                chartData: this.results.votes.map(vote => vote.votes),
                chartLabels: this.results.votes.map(vote => vote.name),
            }
        }
    }
</script>

<style scoped>

</style>