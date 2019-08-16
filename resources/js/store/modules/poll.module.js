import ApiService, { PollService } from "../../common/api.service"
import { FETCH_POLL, STORE_POLL } from "../actions.type"
import { SET_POLL, STORED_POLL} from "../mutations.type"

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
    },
    [STORE_POLL](context, data) {
        return new Promise((resolve, reject) => {
            ApiService.post("polls", data)
                .then(({ data }) => {
                    context.commit(STORED_POLL, data)
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    }
}

const mutations = {
    [SET_POLL](state, poll) {
        state.isLoadingPoll = false
        state.poll = poll
    },
    [STORED_POLL](state, poll) {

    }
}

export default {
    state,
    getters,
    actions,
    mutations
}