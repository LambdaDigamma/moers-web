<template>

    <div>

        <div v-if="this.results.total !== 0">
            <PollChart :chartData="chartData" :chartLabels="chartLabels"  />
            <div class="mt-4 rounded dark:text-white">
                <div class="flex align-items-center">
                    <p v-if="this.results.total === 1" class="m-0 font-bold">
                        Eine Person hat schon abgestimmt.
                    </p>
                    <p v-else class="m-0 font-bold">
                        {{ this.results.total }} Personen haben schon abgestimmt.
                    </p>
                </div>
                <div v-for="(vote, index) in this.votes" :key="index">
                    <div class="flex flex-col sm:flex-row justify-start items-center">
                        <div class="mt-2 sm:mt-0 px-2 py-1 rounded dark:bg-yellow-500 dark:text-gray-900">Stimmen: {{ vote.votes }}</div>
                        <div class="text-center sm:text-left sm:ml-2 mt-2 sm:mt-0">{{ vote.name }}</div>
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
                chartData: this.votes.map(vote => vote.votes),
                chartLabels: this.votes.map(vote => vote.name),
            }
        }
    }
</script>

<style scoped>

</style>