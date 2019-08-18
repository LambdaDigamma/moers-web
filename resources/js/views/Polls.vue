<template>

    <div class="mt-0 mt-sm-1 mt-md-2">

        <b-card bg-variant="secondary" text-variant="black" class="mb-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch">
                <h3 class="m-0">Unbeantwortete Abstimmungen</h3>
                <can I="create-poll" a="Poll">
                    <b-button variant="success" :to="{ name: 'polls.create' }" class="mt-2 mt-sm-0">Hinzufügen</b-button>
                </can>
            </div>
        </b-card>

        <div class="d-flex justify-content-center m-5" v-if="isLoadingPolls">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <b-card 
            v-for="(poll, index) in unansweredPolls"
            :key="poll.id"
            class="mb-2">
            <h4>{{ poll.question }}<small class="ml-2 text-muted"><br>gestellt von <b>{{ poll.group.name }}</b></small></h4>
            <b-card-text>
                {{ poll.description }}
            </b-card-text>
            <b-button :to="{ name: 'polls.poll', params: { id: poll.id } }" variant="primary">Abstimmen</b-button>
        </b-card>

        <b-card bg-variant="secondary" text-variant="black" class="my-4">
            <h3 class="m-0">Beantwortete Abstimmungen</h3>
        </b-card>

        <div class="d-flex justify-content-center m-5" v-if="isLoadingPolls">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <b-card
                v-for="(poll, index) in answeredPolls"
                :key="poll.id"
                class="mb-2">
            <h4>{{ poll.question }}<small class="ml-2 text-muted"><br>gestellt von <b>{{ poll.group.name }}</b></small></h4>
            <b-card-text>
                <div v-if="poll.results.total === 1">
                    {{ poll.results.total }} Benutzer hat abgestimmt.
                </div>
                <div v-else>
                    {{ poll.results.total }} Benutzer haben abgestimmt.
                </div>
            </b-card-text>
            <b-button :to="{ name: 'polls.poll', params: { id: poll.id } }" variant="primary">Ergebnisse ansehen</b-button>
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
        ...mapGetters(["isAuthenticated", "isLoadingPolls", "polls", "unansweredPolls", "answeredPolls"])
    }
}

</script>