<template>

    <div id="app">

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
                    </b-navbar-nav>
                </b-collapse>
            </b-container>

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