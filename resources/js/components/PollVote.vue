<template>

    <div>
        <div class="mt-4">
            <h4>{{ poll.question }}</h4>
            <p>{{ poll.description }}</p>
        </div>

        <div>

            <b-list-group>
                <b-list-group-item v-for="option in poll.options" :key="option.id">
                    {{ option.name }}
                </b-list-group-item>
            </b-list-group>

            <p class="text-muted mt-2 ml-2"><em>0/{{ poll.max_check }} Antworten ausgewählt</em></p>

        </div>

        <b-button block variant="success" size="lg" :disabled="true">Abstimmen</b-button>

        <div class="mt-2">
            <b-link @click.prevent="abstain">Ich möchte mich enthalten.</b-link>
        </div>

    </div>

</template>

<script>
import { ABSTAIN_POLL } from "../store/actions.type";

export default {
    name: "PollVote",
    props: {
        poll: {
            type: Object,
            required: true
        }
    },
    data() {

    },
    methods: {
        abstain() {
            this.$store.dispatch(ABSTAIN_POLL, this.poll.id)
        }
    }
}

</script>

<style scoped>

    .list-group-item.active {
        background-color: #00ff008e;
        border-color: inherit;
        color: black;
    }

    .list-group-item:hover {
        background-color: lightgray;
        cursor: pointer;
    }

</style>
