<template>

    <div class="card" style="margin-top: 2em">

        <div class="card-header d-flex align-items-center justify-content-between">
            <h5>Veranstaltungen</h5>
            <div class="d-flex align-items-end w-50">
                <router-link class="btn btn-success text-white mr-3 w-25" :to="{ 'name': 'event-add' }" title="Add Event">
                    <b class="text-white">Hinzufügen</b>
                </router-link>

                <div class="input-group w-75">
                    <input type="text" class="form-control" placeholder="Veranstaltung suchen" aria-label="Suchbegriff" v-model="searchTerm">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button">Suchen</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <b-table striped bordered hover
                     :items="events"
                     :primary-key="'id'"
                     :fields="fields"
                     @row-clicked="showDetails">
                <div slot="table-busy" class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </b-table>
        </div>

    </div>

</template>

<script>
    import { mapState } from 'vuex'
    export default {
        name: "Events",
        data() {
            return {
                isBusy: true,
                fields: [
                    {
                        key: 'id',
                        label: 'ID',
                        sortable: true
                    },
                    {
                        key: 'name',
                        sortable: true
                    },
                    {
                        key: 'start_date',
                        label: 'Start',
                        sortable: true
                    }
                ],
                searchTerm: "",
            }
        },
        mounted() {
            // this.$store.dispatch('getEvents')
        },
        computed: {
            ...mapState([
             'events',
            ])
        },
        methods: {
            showDetails(item) {
                this.$router.push({ name: 'event-detail', params: { id: item.id } })
            },
        }
    }

</script>

<style scoped>

</style>