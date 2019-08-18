import { AdminService } from "../../common/api.service"
import {ADMIN_FETCH_GROUPS, ADMIN_JOIN_GROUP, ADMIN_LEAVE_GROUP, ADMIN_UPDATE_USER} from "../actions.type";
import { ADMIN_SET_GROUPS, ADMIN_SET_USER } from "../mutations.type";

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
    [ADMIN_UPDATE_USER](context, data) {
        return new Promise((resolve, reject) => {
            return AdminService.updateUser(data.user_id, data)
                .then(({ data }) => {
                    context.commit(ADMIN_SET_USER, data)
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
    [ADMIN_JOIN_GROUP](context, data) {
        return new Promise((resolve, reject) => {
            return AdminService.joinGroup(data.user_id, data)
                .then(({ data }) => {
                    context.commit(ADMIN_SET_USER, data)
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
    [ADMIN_LEAVE_GROUP](context, data) {
        return new Promise((resolve, reject) => {
            return AdminService.leaveGroup(data.user_id, data)
                .then(({ data }) => {
                    context.commit(ADMIN_SET_USER, data)
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    }
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