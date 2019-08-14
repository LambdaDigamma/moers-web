<template>

    <div class="mt-4">

        <b-card bg-variant="secondary" text-variant="black">
            <h3 class="m-0">Organisationen</h3>
        </b-card>      

        <div class="d-flex justify-content-center m-5" v-if="isLoading">
            <b-spinner label="Lädt..."></b-spinner>
        </div>

        <div class="mt-4">
            <b-card v-for="organisation in organisations" :key="organisation.id" class="organisation-card mb-3" @click="showOrganisation(organisation.id)">
                <b-media vertical-align="center">
                    <b-img slot="aside" :src="organisation.logo_url" width="150" alt="placeholder" rounded></b-img>

                    <h5 class="mt-0">{{ organisation.name }}</h5>
                    <p>
                        {{ organisation.description }}
                    </p>
                    <router-link tag="b-button" :to="{ name: 'organisation', params: { id: organisation.id } }">Mehr erfahren</router-link>
                </b-media>
            </b-card>
        </div>

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
    },
    methods: {
        showOrganisation(id) {
            console.log("Testingt")
            this.$router.push({ name: "organisation", params: { id: id } })
        }
    }
}

</script>

<style scoped>

    .organisation-card:hover {
        cursor: pointer;
        background-color: #d3d3d338;
    }

</style>