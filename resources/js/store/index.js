import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth.module'
import organisations from './modules/organisations.module'
import polls from './modules/polls.module'
import poll from './modules/poll.module'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
        organisations,
        polls,
        poll
    }
});