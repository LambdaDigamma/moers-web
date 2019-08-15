<template>

    <div>

        <b-card bg-variant="secondary" text-variant="black" class="my-4">
            <h3 class="m-0">Abstimmungen</h3>
        </b-card>

        <div class="d-flex justify-content-center m-5" v-if="isLoadingPolls">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <b-card 
            v-for="(poll, index) in polls"
            :key="index" 
            class="mb-2">
            <h4>{{ poll.question }}<small class="ml-2 text-muted"><br>gestellt von <b>{{ poll.group.name }}</b></small></h4>
            <b-card-text>
                {{ poll.description }}
            </b-card-text>
            <b-button :to="{ name: 'polls.poll', params: { id: poll.id } }" variant="primary">Abstimmen</b-button>
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