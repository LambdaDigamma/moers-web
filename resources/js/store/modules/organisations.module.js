import { OrganisationService } from "../../common/api.service";
import { FETCH_ORGANISATIONS } from "../actions.type";
import { SET_ORGANISATIONS } from "../mutations.type";

const state = {
    organisations: [],
    isLoading: true
}

const getters = {
    organisations(state) {
        return state.organisations
    },
    isLoading(state) {
        return state.isLoading
    }
}

const actions = {
    [FETCH_ORGANISATIONS]({ commit }) {
        return OrganisationService.get()
            .then(({ data }) => {
                commit(SET_ORGANISATIONS, data)
            })
            .catch(error => {
                throw new Error(error)
            })
    }
}

const mutations = {
    [SET_ORGANISATIONS](state, organisations) {
        state.organisations = organisations
        state.isLoading = false
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}