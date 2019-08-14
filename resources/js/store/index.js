import Vue from 'vue'
import Vuex from 'vuex'

import { abilityPlugin, ability as appAbility } from '../abilities'

import auth from './modules/auth.module'
import organisations from './modules/organisations.module'
import organisation from './modules/organisation.module'
import events from './modules/events.module'
import polls from './modules/polls.module'
import poll from './modules/poll.module'
import users from './modules/users.module'

Vue.use(Vuex)

export const ability = appAbility

export default new Vuex.Store({
    plugins: [
        abilityPlugin
    ],
    modules: {
        auth,
        organisations,
        organisation,
        events,
        polls,
        poll,
        users
    }
});