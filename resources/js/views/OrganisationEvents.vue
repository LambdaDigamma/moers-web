<template>
    
    <div class="mt-4">
        <EventItem v-for="event in organisation.events" :key="event.id" :event='event' :organisation='organisation'></EventItem>
    </div>

</template>

<script>

import EventItem from "../components/EventItem"
import { mapGetters } from "vuex"

export default {
    name: 'OrganisationEvents',
    components: {
        EventItem
    },
    computed: {
        ...mapGetters(["currentUser", "isAuthenticated", "organisation"])
    },
}

</script>
