<template>
    <div class="mt-5">

        <b-card class="event-card mb-3" v-for="group in currentUser.groups" :key="group.id">
            <b-media vertical-align="center">
                <h5 class="mt-0 mb-0">{{ group.name }}</h5>
                <p class="text-muted mt-0 mb-0">{{ group.description }}</p>
            </b-media>
        </b-card>

    </div>
</template>

<script>
    import { mapGetters } from "vuex";

    export default {
        name: "ProfileGroups",
        computed: {
            ...mapGetters(["currentUser"])
        }
    }
</script>

<style scoped>

</style>