import { AdminService } from "../../common/api.service"
import { ADMIN_FETCH_GROUPS } from "../actions.type";
import { ADMIN_SET_GROUPS } from "../mutations.type";

const state = {
    groups: [],
}

const getters = {
    groups(state) {
        return state.groups
    },
}

const actions = {
    [ADMIN_FETCH_GROUPS]({ commit }) {
        return AdminService.getGroups()
            .then(({ data }) => {
                commit(ADMIN_SET_GROUPS, data)
            })
            .catch(error => {
                throw new Error(error)
            })
    },
}

const mutations = {
    [ADMIN_SET_GROUPS](state, groups) {
        state.groups = groups
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}