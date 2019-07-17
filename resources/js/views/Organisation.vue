<template>

    <div class="mt-5">

        <b-row>
            <b-col cols="3">
                <b-img rounded fluid :src="organisation.logo_url" class="mt-4"></b-img>
            </b-col>
            <b-col cols="9">
                <h1>{{ organisation.name }}</h1>
                <p class="text-muted">{{ organisation.description }}</p>
                <b-button variant="success" v-if="isAuthenticated">Folgen</b-button>
            </b-col>
        </b-row>
        <div class="mt-4">
            <b-nav tabs justified>
                <b-nav-item :to="{ name: 'organisation-news' }">Neuigkeiten</b-nav-item>
                <b-nav-item :to="{ name: 'organisation-events' }">Veranstaltungen</b-nav-item>
                <b-nav-item :to="{ name: 'organisation-entry' }">Eintrag</b-nav-item>
            </b-nav>
        </div>
        <router-view></router-view>

    </div>

</template>

<script>

import store from "../store"
import { mapGetters } from "vuex"
import { FETCH_ORGANISATION } from "../store/actions.type"

export default {
    name: "Organisation",
    props: {
        id: {
            type: Number,
            required: true
        }
    },
    beforeRouteEnter(to, from, next) {
        Promise.all([
            store.dispatch(FETCH_ORGANISATION, to.params.id)
        ]).then(() => {
            next()
        })
    },
    computed: {
        ...mapGetters(["currentUser", "isAuthenticated", "organisation"])
    },
}

</script>
