import Vue from 'vue'
import Vuex from 'vuex'

import { alert } from './alert.module';
import { authentication } from './authentication.module';

import state from './state'
import mutations from './mutations'
import actions from './actions'
import getters from './getters'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        alert,
        authentication
    },
    state,
    mutations,
    actions,
    getters
})