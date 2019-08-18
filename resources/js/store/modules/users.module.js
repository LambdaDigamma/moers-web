import { UserService } from "../../common/api.service"
import { FETCH_USERS, FETCH_USER } from "../actions.type";
import { ADMIN_SET_USER, SET_USERS } from "../mutations.type";

const state = {
    users: [],
    user: {},
    isLoadingUsers: true
}

const getters = {
    users(state) {
        return state.users
    },
    isLoadingUsers(state) {
        return state.isLoadingUsers
    },
    user(state) {
        return state.user
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
    },
    async [FETCH_USER](context, id) {
        const { data } = await UserService.getDetail(id)
        context.commit(ADMIN_SET_USER, data)
        return data
    }
}

const mutations = {
    [SET_USERS](state, users) {
        state.users = users
        state.isLoadingUsers = false
    },
    [ADMIN_SET_USER](state, user) {
        state.user = user
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}