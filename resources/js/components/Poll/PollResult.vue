<template>
    <b-card>
        <div class="mb-5">
            <h4>{{ poll.question }}</h4>
            <p class="text-justify">{{ poll.description }}</p>
        </div>
        <PollChart
            :chartData="chartData"
            :chartLabels="chartLabels"
        ></PollChart>
        <b-list-group class="mt-3">
            <b-list-group-item class="d-flex align-items-center">
                <p v-if="poll.results.total === 1" class="m-0 font-weight-bold">
                    Eine Person hat schon abgestimmt.
                </p>
                <p v-else class="m-0 font-weight-bold">
                    {{ poll.results.total }} Personen haben schon abgestimmt.
                </p>
            </b-list-group-item>
            <b-list-group-item
                v-for="(vote, index) in poll.results.votes"
                :key="index"
            >
                <div
                    class="d-flex flex-sm-row flex-column justify-content-start"
                >
                    <b-badge variant="secondary" class="mt-2 mt-sm-0"
                        >Stimmen: {{ vote.votes }}</b-badge
                    >
                    <div
                        class="mt-2 text-center text-justify text-sm-left ml-sm-2 mt-sm-0"
                    >
                        {{ vote.name }}
                    </div>
                </div>
            </b-list-group-item>
        </b-list-group>
    </b-card>
</template>

<script>
import PollChart from "./PollChart.vue";
export default {
    name: "PollResult",
    components: { PollChart },
    props: {
        poll: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            chartData: this.poll.results.votes.map((vote) => vote.votes),
            chartLabels: this.poll.results.votes.map((vote) => vote.name),
        };
    },
};
</script>

<style scoped></style>
