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
    }
}