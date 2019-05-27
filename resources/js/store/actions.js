import axios from 'axios'

export default {
    getEvents({ commit }) {
        axios
            .get('/api/v2/moers-festival/events', {
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(r => r.data)
            .then(events => {
                commit('SET_EVENTS', events)
            })
    },
    createEvent({ commit }) {
        // axios.post('/url/v2/moers-festival/events')
    },
    getEntries({ commit }) {
        axios
            .get('/api/v2/entries', {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.data)
            .then(entries => {
                commit('SET_ENTRIES', entries)
            })
    },
    resetEventForm({ commit }) {
        commit('RESET_EVENT_FORM')
    },
    enableEventEditMode({ commit }) {
        commit('SET_EVENT_EDITING', true)
    },
    toggleEditModeEvent({ commit }) {
        commit('TOGGLE_EVENT_EDIT')
    }
}