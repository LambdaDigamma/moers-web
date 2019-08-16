<template>
    
    <div>

        <b-card bg-variant="secondary" text-variant="black" class="my-4">
            <h3 class="m-0">Abstimmung</h3>
        </b-card>

        <div class="d-flex justify-content-center m-5" v-if="isLoadingPoll">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <PollVote v-if="poll.results === null" :poll='poll'>

        </PollVote>
        <PollResult v-else :poll='poll'>

        </PollResult>

    </div>

</template>

<script>

import store from "../store"
import PollVote from "../components/PollVote"
import { mapGetters } from "vuex"
import { FETCH_POLL } from "../store/actions.type"
import PollResult from "../components/Poll/PollResult";

export default {
    name: "Poll",
    components: {
        PollVote,
        PollResult
    },
    props: {
        id: {
            type: Number,
            required: true
        }
    },
    beforeRouteEnter(to, from, next) {
        Promise.all([
            store.dispatch(FETCH_POLL, to.params.id)
        ]).then(() => {
            next();
        });
    },
    computed: {
        ...mapGetters(["currentUser", "isAuthenticated", "isLoadingPoll", "poll"])
    },
}

</script>
