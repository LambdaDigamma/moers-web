<template>

    <div style="margin-top: 2em">

        <b-card header="Veranstaltung hinzufügen">
            <div slot="header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>Veranstaltung hinzufügen</h5>
                </div>
            </div>

            <event-form></event-form>

        </b-card>

    </div>

</template>

<script>
    import EventForm from './../components/EventForm.vue'
    import { mapActions, mapState } from 'vuex'
    export default {
        name: 'EventAdd',
        components: { EventForm },
        computed: {
            ...mapState(['events', 'entries', 'isEditingEvents']),
        },
        methods: {
            ...mapActions(['enableEventEditMode'])
        },
        mounted() {
            this.enableEventEditMode()
        }
    }
</script>