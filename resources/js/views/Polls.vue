<template>

    <div class="mt-4">

        <div class="mb-4">
            <hr>
            <h3>Aktive Abstimmungen</h3>
            <b-button variant="secondary">Ergebnisse</b-button>
            <hr>
        </div>

        <div class="d-flex justify-content-center m-5" v-if="isLoadingPolls">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <b-card 
            v-for="(poll, index) in polls" 
            :title="poll.question" 
            :key="index" 
            class="mb-2">

            <b-card-text>
                
            </b-card-text>
            <b-button href="#" variant="primary">Abstimmen</b-button>
        </b-card>

    </div>

</template>

<script>
import { mapGetters } from "vuex";
import { FETCH_POLLS } from '../store/actions.type';

export default {
    name: "Polls",
    mounted() {
        this.$store.dispatch(FETCH_POLLS)
    },
    computed: {
        ...mapGetters(["isAuthenticated", "isLoadingPolls", "polls"])
    }
}

</script>