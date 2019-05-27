<template>

    <div style="margin-top: 2em">

        <b-card header="Veranstaltung hinzufügen">
            <div slot="header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>Veranstaltung hinzufügen</h5>
                </div>
            </div>

            <event-form @submit="onSubmit"></event-form>

        </b-card>

    </div>

</template>

<script>
    import EventForm from './../components/EventForm.vue'
    import { mapActions, mapState, mapGetters } from 'vuex'
    export default {
        name: 'EventAdd',
        components: { EventForm },
        computed: {
            ...mapState(['events', 'entries', 'isEditingEvents', 'eventForm']),
        },
        methods: {
            ...mapActions(['enableEventEditMode']),
            ...mapGetters(['getCurrentEventPayload']),
            onSubmit() {

                let event = this.eventForm

                if (event.extras.ticket !== null) {
                    if (event.extras.ticket == 'Festival-Ticket') {
                        event.extras.needsFestivalTicket = true
                    } else if (event.extras.ticket == 'Both') {
                        event.extras.visitWithExtraTicket = true
                    } else if (event.extras.ticket == 'Free') {
                        event.extras.isFree = true
                    }

                }

                delete event.extras.ticket
                let start = null
                let end = null

                if (event.startDate !== null) {
                    start = event.startDate

                    if (event.startTime !== null) {
                        start += ' ' + event.startTime
                    } else {
                        start += ' 00:00:00'
                    }


                    if (event.endDate !== null) {
                        end = event.endDate

                        if (event.endTime !== null) {
                            end += ' ' + event.endTime
                        } else {
                            end += ' 00:00:00'
                        }

                    }

                }


                delete event.startDate
                delete event.startTime
                delete event.startUnknown
                delete event.endDate
                delete event.endTime
                delete event.endUnknown

                alert(JSON.stringify(event))

            }
        },
        mounted() {
            this.enableEventEditMode()
        }
    }
</script>