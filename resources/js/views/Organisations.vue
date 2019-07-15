<template>

    <div class="mt-4">

        <div class="mb-4">
            <hr>
            <h3>Organisationen</h3>
            <hr>
        </div>        

        <div class="d-flex justify-content-center m-5" v-if="isLoading">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <b-card-group deck>
            <b-card v-for="(organisation, index) in organisations" :title="organisation.name" :key="index">
                <b-card-text>
                    {{ organisation.description }}
                </b-card-text>
                <b-button v-if="isAuthenticated" href="#" variant="primary">Folgen</b-button>
            </b-card>
        </b-card-group>
    </div>

</template>

<script>
import { mapGetters } from "vuex";
import { FETCH_ORGANISATIONS } from '../store/actions.type';

export default {
    name: "Organisations",
    mounted() {
        this.$store.dispatch(FETCH_ORGANISATIONS)
    },
    computed: {
        ...mapGetters(["isAuthenticated", "isLoading", "organisations"])
    }
}

</script>

<style scoped>

</style>