import { updateField } from 'vuex-map-fields';

export default {
    updateField,
    SET_EVENTS(state, events) {
        state.events = events
    },
    SET_ENTRIES(state, entries) {
        state.entries = entries
    },
    SET_EVENT_EDITING(state, status) {
        state.isEditingEvents = status
    },
    TOGGLE_EVENT_EDIT(state) {
        state.isEditingEvents = !state.isEditingEvents
    },
    RESET_EVENT_FORM(state) {
        state.eventForm.name = ''
        state.eventForm.descriptionDE = ''
        state.eventForm.descriptionEN = ''
        state.eventForm.startUnknown = true
        state.eventForm.startDate = null
        state.eventForm.startTime = null
        state.eventForm.endUnknown = true
        state.eventForm.endDate = null
        state.eventForm.endTime = null
    }
}