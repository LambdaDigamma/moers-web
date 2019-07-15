<template>
    
    <div class="mt-5">
        
        <div class="d-flex justify-content-center m-5" v-if="isLoading">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <h4>{{ poll.question }}</h4>
        <p>{{ poll.description }}</p>

    </div>

</template>

<script>

import store from "../store"
import { mapGetters } from "vuex"
import { FETCH_POLL } from "../store/actions.type"

export default {
    name: "Poll",
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
