import { OrganisationService } from "../../common/api.service"
import { FETCH_ORGANISATION } from "../actions.type"
import { SET_ORGANISATION } from "../mutations.type"

const state = {
    organisation: {},
}

const getters = {
    organisation() {
        return state.organisation
    }
}

const actions = {
    async [FETCH_ORGANISATION](context, id) {
        const { data } = await OrganisationService.get(id)
        context.commit(SET_ORGANISATION, data)
        return data
    }
}

const mutations = {
    [SET_ORGANISATION](state, organisation) {
        state.organisation = organisation
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}