<template>
    <b-card>
        <div class="mb-5">
            <h4>{{ poll.question }}</h4>
            <p class="text-justify">{{ poll.description }}</p>
        </div>
        <PollChart :chartData="chartData" :chartLabels="chartLabels"></PollChart>
        <b-list-group class="mt-3">
            <b-list-group-item class="d-flex align-items-center">
                <p v-if="poll.results.total === 1" class="m-0 font-weight-bold">
                    Eine Person hat schon abgestimmt.
                </p>
                <p v-else class="m-0 font-weight-bold">
                    {{ poll.results.total }} Personen haben schon abgestimmt.
                </p>
            </b-list-group-item>
            <b-list-group-item class="d-flex align-items-center" v-for="(vote, index) in poll.results.votes"  :key="vote.id">
                <b-container>
                    <b-row>
                        <b-col cols="2">
                            <b-badge variant="secondary" >Stimmen: {{ vote.votes }}</b-badge>
                        </b-col>
                        <b-col cols="10">
                            {{ vote.name }}
                        </b-col>
                    </b-row>
                </b-container>
            </b-list-group-item>
        </b-list-group>
    </b-card>
</template>

<script>
    import PollChart from "./PollChart";
    export default {
        name: "PollResult",
        components: { PollChart },
        props: {
            poll: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                chartData: this.poll.results.votes.map(vote => vote.votes),
                chartLabels: this.poll.results.votes.map(vote => vote.name),
            }
        }
    }
</script>

<style scoped>

</style>