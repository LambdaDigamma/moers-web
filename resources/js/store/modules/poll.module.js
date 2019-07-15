import { PollService } from "../../common/api.service"
import { FETCH_POLL } from "../actions.type"
import { SET_POLL } from "../mutations.type"

const state = {
    poll: {},
    isLoadingPoll: true
}

const getters = {
    poll() {
        return state.poll
    },
    isLoadingPoll(state) {
        return state.isLoadingPoll
    }
}

const actions = {
    async [FETCH_POLL](context, id) {
        const { data } = await PollService.get(id)
        context.commit(SET_POLL, data)
        return data
    }
}

const mutations = {
    [SET_POLL](state, poll) {
        state.isLoadingPoll = false
        state.poll = poll
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}