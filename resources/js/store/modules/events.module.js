import { EventService } from "../../common/api.service"
import { FETCH_EVENTS } from "../actions.type";
import { SET_EVENTS } from "../mutations.type";

const state = {
    events: [],
    isLoadingEvents: true
}

const getters = {
    events(state) {
        return state.events
    },
    isLoadingEvents(state) {
        return state.isLoadingEvents
    }
}

const actions = {
    [FETCH_EVENTS]({ commit }) {
        return EventService.get()
            .then(({ data }) => {
                commit(SET_EVENTS, data)
            })
            .catch(error => {
                throw new Error(error)
            })
    }
}

const mutations = {
    [SET_EVENTS](state, events) {
        state.events = events
        state.isLoadingEvents = false
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}