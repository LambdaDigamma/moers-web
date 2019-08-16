import { PollService } from "../../common/api.service";
import { FETCH_POLLS } from "../actions.type";
import { SET_POLLS } from "../mutations.type";

const state = {
    polls: [],
    isLoadingPolls: true
}

const getters = {
    polls(state) {
        return state.polls
    },
    answeredPolls(state) {
        return state.polls.filter(poll => poll.has_user_vote)
    },
    unansweredPolls(state) {
        return state.polls.filter(poll => !poll.has_user_vote)
    },
    isLoadingPolls(state) {
        return state.isLoadingPolls
    }
}

const actions = {
    [FETCH_POLLS]({ commit }) {
        return PollService.get()
            .then(({ data }) => {
                commit(SET_POLLS, data)
            })
            .catch(error => {
                throw new Error(error)
            })
    }
}

const mutations = {
    [SET_POLLS](state, polls) {
        state.polls = polls
        state.isLoadingPolls = false
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}