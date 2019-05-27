<template>

    <b-form>

        <!-- Name -->
        <b-form-group
                id="input-group-name"
                label="Name:"
                label-for="name"
                label-cols="4"
                label-cols-lg="2">
            <b-form-input
                    id="name"
                    type="text"
                    required
                    v-model="name"
                    placeholder="Name"
                    :disabled="!isEditingEvents" />
        </b-form-group>

        <!-- Description (DE) -->
        <b-form-group
                id="input-group-description"
                label="Beschreibung (DE):"
                label-for="description-german"
                label-cols="4"
                label-cols-lg="2">
            <b-form-textarea
                    id="description-german"
                    placeholder="Füge die deutsche Beschreibung hinzu..."
                    v-model="descriptionDE"
                    :disabled="!isEditingEvents">

            </b-form-textarea>
        </b-form-group>

        <!-- Description (EN) -->
        <b-form-group
                id="input-group-description"
                label="Beschreibung (EN):"
                label-for="description-english"
                label-cols="4"
                label-cols-lg="2">
            <b-form-textarea
                    id="description-english"
                    placeholder="Füge die englische Beschreibung hinzu..."
                    v-model="descriptionEN"
                    :disabled="!isEditingEvents">
            </b-form-textarea>
        </b-form-group>

        <!-- Start -->
        <b-form-group
                id="input-group-datetime-start"
                label="Beginn:"
                label-for="start_date"
                label-cols="4"
                label-cols-lg="2">

            <b-form-checkbox
                    id="checkbox-start-unknown"
                    name="checkbox-start-unknown"
                    v-model="isStartUnknown"
                    :disabled="!isEditingEvents">
                Beginn unbekannt
            </b-form-checkbox>

            <b-row class="my-1">
                <b-col sm="6">
                    <b-form-input
                            id="start_date"
                            :disabled="!isEditingEvents || isStartUnknown"
                            :type="'date'">

                    </b-form-input>
                </b-col>
                <b-col sm="6">
                    <b-form-input
                            id="start_time"
                            :disabled="!isEditingEvents || isStartUnknown"
                            :type="'time'">

                    </b-form-input>
                </b-col>
            </b-row>

        </b-form-group>

        <!-- End -->
        <b-form-group
                id="input-group-datetime-start"
                label="Ende:"
                label-for="end_date"
                label-cols="4"
                label-cols-lg="2">

            <b-form-checkbox
                    id="checkbox-end-unknown"
                    name="checkbox-end-unknown"
                    v-model="isEndUnknown"
                    :disabled="!isEditingEvents">
                Ende unbekannt
            </b-form-checkbox>

            <b-row class="my-1">
                <b-col sm="6">
                    <b-form-input date
                                  id="end_date"
                                  :disabled="!isEditingEvents || isEndUnknown"
                                  :type="'date'">

                    </b-form-input>
                </b-col>
                <b-col sm="6">
                    <b-form-input time
                                  id="end_time"
                                  :disabled="!isEditingEvents || isEndUnknown"
                                  :type="'time'">

                    </b-form-input>
                </b-col>
            </b-row>

        </b-form-group>

        <!-- Entry -->
        <b-form-group
                id="input-group-entry"
                label="Ort:"
                label-for="entry"
                label-cols="4"
                label-cols-lg="2">

            <b-form-select v-model="entryID" :options="entriesOptions" :disabled="!isEditingEvents">

            </b-form-select>

        </b-form-group>

        <!-- Ticket -->
        <b-form-group
                id="input-group-ticket"
                label="Ticket:"
                label-for="ticket"
                label-cols="4"
                label-cols-lg="2">

            <b-form-select v-model="ticket" :options="ticketOptions" :disabled="!isEditingEvents">

            </b-form-select>

        </b-form-group>

        <!-- Color -->
        <b-form-group
                id="input-group-color"
                label="Akzent-Farbe:"
                label-for="color"
                label-cols="4"
                label-cols-lg="2">

            <b-form-select v-model="color" :options="colorOptions" :disabled="!isEditingEvents">

            </b-form-select>

        </b-form-group>

        <!-- Image -->
        <b-form-group
                id="input-group-image-url"
                label="Bilder:"
                label-for="image_url"
                label-cols="4"
                label-cols-lg="2">

            <b-row class="my-1">
                <b-col sm="6">
                    <b-form-input
                            id="image_url"
                            type="url"
                            placeholder="URL des Header-Bildes"
                            :disabled="!isEditingEvents">

                    </b-form-input>
                </b-col>
                <b-col sm="6">
                    <b-form-input
                            id="icon_url"
                            type="url"
                            placeholder="URL des Icons"
                            :disabled="!isEditingEvents">

                    </b-form-input>
                </b-col>
            </b-row>

        </b-form-group>

        <!-- URL -->
        <b-form-group
                id="input-group-url"
                label="URL:"
                label-for="url"
                label-cols="4"
                label-cols-lg="2">

            <b-form-input
                    id="url"
                    type="url"
                    placeholder="URL"
                    :disabled="!isEditingEvents">

            </b-form-input>

        </b-form-group>

        <!-- Organisation -->
        <!-- TODO: Add this -->

    </b-form>

</template>

<script>
    import { mapActions, mapGetters, mapState } from 'vuex'
    import { mapFields } from 'vuex-map-fields';
    export default {
        name: "EventForm",
        data() {
            return {
                isEditing: false,
                ticket: null,
                ticketOptions: [
                    { value: null, text: 'Noch nicht festgelegt...' },
                    { value: 'Festival-Ticket', text: 'Festival-Ticket' },
                    { value: 'Both', text: 'Mörzz-Ticket oder Festival-Ticket' },
                    { value: 'Free', text: 'Free' }
                ],
                color: null,
                colorOptions: [
                    { value: null, text: 'Keine festgelegt' },
                    { value: 'yellow', text: 'mœrsify (Gelb)' },
                    { value: 'black', text: 'ENNI Eventhalle (Schwarz)' },
                    { value: 'blue', text: 'Innenstadt (Blau)' },
                    { value: 'orange', text: 'mœrs sessions (Orange)' },
                    { value: 'magenta', text: 'Festivaldorf (Magenta)' },
                    { value: 'green', text: 'Park (Grün)' }
                ],
                entryID: null,
            }
        },
        computed: {
            ...mapState(['events', 'entries', 'isEditingEvents']),
            ...mapGetters(['getEventById', 'getEvent']),
            ...mapFields({
                name: 'eventForm.name',
                descriptionDE: 'eventForm.descriptionDE',
                descriptionEN: 'eventForm.descriptionEN',
                isStartUnknown: 'eventForm.startUnknown',
                isEndUnknown: 'eventForm.endUnknown',
            }),
            entriesOptions() {
                let options = this.entries.map(entry => {
                    return { value: entry.id, text: entry.name }
                })
                options.splice(0, 0, { value: null, text: 'Ort unbekannt' })
                return options
            }
        },
        methods: {
            ...mapActions([
                "getEntries",
                "getEvents"
            ])
        }
    }
</script>

<style scoped>

</style>