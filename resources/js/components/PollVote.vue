<template>

    <div>
        <div class="mt-4">
            <h4>{{ poll.question }}</h4>
            <p>{{ poll.description }}</p>
        </div>

        <div>

            <b-list-group>
                <b-list-group-item v-for="option in poll.options" :key="option.id" @click="clickedOption(option.id)">
                    <b-badge v-if="selectionIndex.includes(option.id)" variant="success">Ausgewählt</b-badge>
                    {{ option.name }}
                </b-list-group-item>
            </b-list-group>

            <p class="text-muted mt-2 ml-2"><em>{{ selectionIndex.length }}/{{ poll.max_check }} Antworten ausgewählt</em></p>

        </div>

        <b-button :disabled="!(selectionIndex.length === poll.max_check)" @click="vote" block variant="success" size="lg">Abstimmen</b-button>

        <div class="mt-2">
            <b-link @click.prevent="abstain">Ich möchte mich enthalten.</b-link>
        </div>

    </div>

</template>

<script>
import { ABSTAIN_POLL, VOTE_POLL } from "../store/actions.type";

export default {
    name: "PollVote",
    props: {
        poll: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            selectionIndex: [],
            test: {}
        }
    },
    methods: {
        clickedOption(id) {

            if (this.poll.is_radio) {
                this.selectionIndex = []
                this.selectionIndex.push(id)
            } else {
                if (this.selectionIndex.includes(id)) {
                    const index = this.selectionIndex.indexOf(id)
                    this.selectionIndex.splice(index, 1)
                } else {
                    if (this.selectionIndex.length < this.poll.max_check) {
                        this.selectionIndex.push(id)
                    }
                }
            }

        },
        vote() {

            const payload = {
                poll_id: this.poll.id,
                options: this.selectionIndex
            }

            this.$store.dispatch(VOTE_POLL, payload)

        },
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
