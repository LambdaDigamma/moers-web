<template>

    <div id="app">

        <b-navbar id="nav" toggleable="lg" type="dark" variant="dark">
            <b-navbar-brand to="/">
                Mein Moers
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item to="/organisations">Organisationen</b-nav-item>
                    <b-nav-item to="/events">Veranstaltungen</b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">

                    <b-button to="/login" size="sm" class="my-2 my-sm-0" right v-if="!this.$store.state.authentication.status.loggedIn">
                        Anmelden
                    </b-button>
                    <b-button size="sm" class="my-2 my-sm-0" to="/login" right v-if="this.$store.state.authentication.user !== null">
                        Abmelden
                    </b-button>

                </b-navbar-nav>
            </b-collapse>

        </b-navbar>

        <b-container>
            <div v-if="alert.message" style="margin-top: 2.5em;" :class="`alert ${alert.type}`">{{ alert.message }}</div>
            <router-view/>
        </b-container>
    </div>

</template>

<script>
    export default {
        name: 'app',
        computed: {
            alert () {
                return this.$store.state.alert
            }
        },
        watch: {
            $route (to, from) {
                this.$store.dispatch('alert/clear');
            }
        },
        mounted() {
            this.$store.dispatch('getEvents')
            this.$store.dispatch('getEntries')
        }
    }
</script>