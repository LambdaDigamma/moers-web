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
                    <b-nav-item to="/events" >Veranstaltungen</b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">

                    <b-button to="/login" size="sm" class="my-2 my-sm-0" right v-if="!isLoggedIn">
                        Anmelden
                    </b-button>

                </b-navbar-nav>
            </b-collapse>

        </b-navbar>

        <b-container>
            <router-view/>
        </b-container>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                isLoggedIn : null,
                name : null
            }
        },
        mounted() {
            this.isLoggedIn = localStorage.getItem('jwt');
            this.name = localStorage.getItem('user');
        }
    }
</script>