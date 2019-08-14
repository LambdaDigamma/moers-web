import { UserService} from "../../common/api.service"
import { FETCH_USERS } from "../actions.type";
import { SET_USERS } from "../mutations.type";

const state = {
    users: [],
    isLoadingUsers: true
}

const getters = {
    users(state) {
        return state.users
    },
    isLoadingUsers(state) {
        return state.isLoadingUsers
    }
}

const actions = {
    [FETCH_USERS]({ commit }) {
        return UserService.get()
            .then(({ data }) => {
                commit(SET_USERS, data)
            })
            .catch(error => {
                throw new Error(error)
            })
    }
}

const mutations = {
    [SET_USERS](state, users) {
        state.users = users
        state.isLoadingUsers = false
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}