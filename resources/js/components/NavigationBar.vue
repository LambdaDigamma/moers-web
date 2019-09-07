<template>

    <b-navbar id="nav" toggleable="lg" variant="faded" type="light">
        <b-container>
            <b-navbar-brand to="/">
                <b-navbar-brand tag="h2" class="mb-0">
                    <img src="/svg/mm.svg" width="30" height="30" class="d-inline-block align-top mr-1" alt="Mein Moers Logo">
                    Mein Moers
                </b-navbar-brand>
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <can I="read-poll" a="Poll">
                        <router-link tag="b-nav-item" v-if="isAuthenticated" :to="{ name: 'polls' }" exact>Abstimmungen</router-link>
                    </can>
                    <router-link tag="b-nav-item" :to="{ name: 'organisations' }" exact>Organisationen</router-link>
                    <router-link tag="b-nav-item" :to="{ name: 'events' }" exact>Veranstaltungen</router-link>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto" v-if="isAuthenticated">
                    <b-nav-item-dropdown right>
                        <template slot="button-content">{{ currentUser.name }}</template>
                        <b-dropdown-item :to="{ name: 'profile-organisations' }">Profil</b-dropdown-item>
                        <b-dropdown-item :to="{ name: 'admin' }" v-if="$can('access-admin')">Admin</b-dropdown-item>
                        <b-dropdown-item @click="logout">Abmelden</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto" v-if="!isAuthenticated">
                    <router-link tag="b-nav-item" right :to="{ name: 'login' }" exact>Anmelden</router-link>
                </b-navbar-nav>
            </b-collapse>
        </b-container>

    </b-navbar>

</template>

<script>

import { mapGetters } from 'vuex'
import { LOGOUT } from '../store/actions.type';

export default {
    name: "NavigationBar",
    computed: {
        ...mapGetters(["currentUser", "isAuthenticated"])
    },
    methods: {
        logout() {
            this.$store.dispatch(LOGOUT).then(() => {
                this.$router.push({ name: "home" });
            });
        }
    }
}

</script>