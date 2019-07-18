<template>

    <div class="mt-5">
        <div class="mt-5 py-5 profile-header text-center">
            <h1 class="text-center">{{ currentUser.name }}</h1>
            <h5 class="text-muted">{{ currentUser.description }}</h5>
            <b-button class="mt-4" :to="{ name: 'profile-settings' }">Profil bearbeiten</b-button>
            <b-button class="mt-4" @click="logout" variant="danger">Abmelden</b-button>
        </div>
        <b-nav tabs justified>
            <b-nav-item :to="{ name: 'profile-organisations' }">Du folgst</b-nav-item>
            <b-nav-item :to="{ name: 'profile-events' }">Deine Favoriten</b-nav-item>
            <b-nav-item :to="{ name: 'profile-settings' }">Einstellungen</b-nav-item>
        </b-nav>
        <router-view></router-view>
    </div>




</template>

<script>

import { mapGetters } from "vuex"
import { LOGOUT } from '../store/actions.type';

export default {
    name: "Profile",
    computed: {
        ...mapGetters(["isAuthenticated", "currentUser"])
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

<style scoped>
    
    .nav-item > a {
        color: rgba(0, 0, 0, 0.5);
    }

</style>