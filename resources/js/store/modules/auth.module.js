import ApiService from "../../common/api.service";
import AuthService from "../../common/auth.service";

import { LOGIN, LOGOUT, REGISTER, CHECK_AUTH, UPDATE_USER } from "../actions.type"
import { SET_AUTH, SET_USER, PURGE_AUTH, SET_ERROR } from "../mutations.type"

const state = {
    errors: null,
    user: {},
    isAuthenticated: !!AuthService.getToken()
};

const getters = {
    currentUser(state) {
        return state.user
    },
    isAuthenticated(state) {
        return state.isAuthenticated
    }
};

const actions = {
    [LOGIN](context, credentials) {
        return new Promise(resolve => {
            ApiService.post("auth/login", credentials)
                .then(({ data }) => {
                    context.commit(SET_AUTH, data)
                    resolve(data)
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data)
                })
        });
    },
    [LOGOUT](context) {
        context.commit(PURGE_AUTH)
    },
    [REGISTER](context, credentials) {
        return new Promise((resolve, reject) => {
            ApiService.post("users", { user: credentials })
                .then(({ data }) => {
                    context.commit(SET_AUTH, data.user)
                    resolve(data)
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data.errors)
                    reject(response)
                })
        });
    },
    [CHECK_AUTH](context) {
        if (AuthService.getToken()) {
            ApiService.setHeader()
            ApiService.get("auth/user")
                .then(({ data }) => {
                    context.commit(SET_USER, data)
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data.errors)
                })
        } else {
            context.commit(PURGE_AUTH)
        }
    },
    [UPDATE_USER](context, payload) {
        const { email, username, password } = payload
        const user = {
            email,
            username,
        };
        if (password) {
            user.password = password
        }

        return ApiService.put("user", user).then(({ data }) => {
            context.commit(SET_AUTH, data.user)
            return data
        });
    }
};

const mutations = {
    [SET_ERROR](state, error) {
        state.errors = error
    },
    [SET_AUTH](state, data) {
        state.isAuthenticated = true
        state.user = data
        state.errors = {}
        AuthService.saveToken(data.token)
    },
    [SET_USER](state, data) {
        state.user = data
        state.errors = {}
    },
    [PURGE_AUTH](state) {
        state.isAuthenticated = false
        state.user = {}
        state.errors = {}
        AuthService.destroyToken()
    }
};

export default {
    state,
    actions,
    mutations,
    getters
};