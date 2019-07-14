<template>

    <div class="mt-4">

        <h3 class="mb-4">Organisationen</h3>

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
    ...mapGetters(["isAuthenticated", "organisations"])
    }
}

</script>

<style scoped>

</style>