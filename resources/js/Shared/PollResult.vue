<template>

    <div>
        <div v-if="this.results.total !== 0">
            <PollChart :chartData="chartData" :chartLabels="chartLabels"  />
            <div class="mt-4 rounded dark:text-white">
                <div class="flex align-items-center">
                    <p v-if="this.results.total === 1" class="m-0 font-semibold">
                        Eine Person hat schon abgestimmt.
                    </p>
                    <p v-else class="m-0 font-semibold">
                        {{ this.results.total }} Personen haben schon abgestimmt.
                    </p>
                </div>
                <h2 class="mt-3 mb-0 font-semibold text-lg dark:text-white">Ergebnisse:</h2>
                <div v-for="(vote, index) in this.results.votes" :key="index">
                    <div class="flex flex-row justify-start items-center">
                        <div class="w-32 mt-2 sm:mt-0 px-2 py-1 font-semibold rounded dark:bg-yellow-500 dark:text-gray-900 text-center">Stimmen: {{ vote.votes }}</div>
                        <div class="sm:text-left ml-2 mt-2 sm:mt-0 text-center font-medium">{{ vote.name }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="font-semibold text-lg dark:text-white">
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