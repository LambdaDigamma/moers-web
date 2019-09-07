import { AdminService } from "../../common/api.service"
import {
    ADMIN_ALLOW_CREATE_POLL, ADMIN_ALLOW_CREATE_POLL_GROUP, ADMIN_DISALLOW_CREATE_POLL, ADMIN_DISALLOW_CREATE_POLL_GROUP,
    ADMIN_FETCH_GROUP,
    ADMIN_FETCH_GROUPS,
    ADMIN_JOIN_GROUP,
    ADMIN_LEAVE_GROUP, ADMIN_UPDATE_GROUP,
    ADMIN_UPDATE_USER
} from "../actions.type";
import {ADMIN_SET_GROUP, ADMIN_SET_GROUPS, ADMIN_SET_USER} from "../mutations.type";

const state = {
    groups: [],
    group: {}
}

const getters = {
    groups(state) {
        return state.groups
    },
    group(state) {
        return state.group
    }
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
    [ADMIN_FETCH_GROUP](context, id) {
        return AdminService.getGroup(id)
            .then(({ data }) => {
                context.commit(ADMIN_SET_GROUP, data)
            })
            .catch(error => {
                throw new Error(error)
            })
    },
    [ADMIN_UPDATE_GROUP](context, data) {
        return new Promise((resolve, reject) => {
            return AdminService.updateGroup(data.group_id, data)
                .then(({ data }) => {
                    context.commit(ADMIN_SET_GROUP, data)
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
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
                    context.commit(ADMIN_SET_USER, data.user)
                    context.commit(ADMIN_SET_GROUP, data.group)
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
                    context.commit(ADMIN_SET_USER, data.user)
                    context.commit(ADMIN_SET_GROUP, data.group)
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
    [ADMIN_ALLOW_CREATE_POLL](context, user_id) {
        return new Promise((resolve, reject) => {
            return AdminService.allowCreatePoll(user_id)
                .then(({ data }) => {
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
    [ADMIN_DISALLOW_CREATE_POLL](context, user_id) {
        return new Promise((resolve, reject) => {
            return AdminService.disallowCreatePoll(user_id)
                .then(({ data }) => {
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
    [ADMIN_ALLOW_CREATE_POLL_GROUP](context, data) {
        return new Promise((resolve, reject) => {
            return AdminService.allowCreatePollGroup(data)
                .then(({ data }) => {
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
    [ADMIN_DISALLOW_CREATE_POLL_GROUP](context, data) {
        return new Promise((resolve, reject) => {
            return AdminService.disallowCreatePollGroup(data)
                .then(({ data }) => {
                    resolve(data)
                })
                .catch(({ response }) => {
                    reject(response.data.errors)
                })
        });
    },
}

const mutations = {
    [ADMIN_SET_GROUPS](state, groups) {
        state.groups = groups
    },
    [ADMIN_SET_GROUP](state, group) {
        state.group = group
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}