<template>

    <div class="mt-4">

        <b-card bg-variant="secondary" text-variant="white">
            <h3 class="m-0">Veranstaltungen</h3>
        </b-card>

        <div class="d-flex justify-content-center m-5" v-if="isLoadingEvents">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <div v-for="(events, day) in events" :key="day">
            <h5 class="mt-4 ml-1">{{ [ day, "DD.MM.YYYY" ] | moment('dddd, MMMM Do YYYY') }}</h5>
            <EventItem v-for="event in events" :key="event.id" :event='event'></EventItem>
        </div>

    </div>

</template>

<script>

import EventItem from "../components/EventItem"
import { mapGetters } from "vuex";
import { FETCH_EVENTS } from '../store/actions.type';

export default {
    name: "Events",
    components: {
        EventItem
    },
    mounted() {
        this.$store.dispatch(FETCH_EVENTS)
    },
    computed: {
        ...mapGetters(["isAuthenticated", "isLoadingEvents", "events"])
    }
}

</script>