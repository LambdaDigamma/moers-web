import { getField } from 'vuex-map-fields';

export default {
    getField,
    getEventById: (state) => (id) => {
        return state.events.find(event => event.id === id)
    },
    getEvent: (state) => (id) => {
        return state.events.find(event => event.id === id)
    },
}