import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ApiService from "./common/api.service"
import { CHECK_AUTH } from "./store/actions.type";

import DateFilter from "./common/date.filter"
import ErrorFilter from "./common/error.filter"

import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUserSecret)

Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(VueMoment)
Vue.filter("date", DateFilter)
Vue.filter("error", ErrorFilter)
Vue.component('font-awesome-icon', FontAwesomeIcon)

ApiService.init()

router.beforeEach((to, from, next) =>
    Promise.all([store.dispatch(CHECK_AUTH)]).then(next)
)

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')