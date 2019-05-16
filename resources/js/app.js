import Vue from 'vue';
import Base from './base';
import axios from 'axios';
import Routes from './routes';
import VueRouter from 'vue-router';
import moment from 'moment-timezone';

require('./bootstrap');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.use(VueRouter);

window.Popper = require('popper.js').default;

// moment.tz.setDefault(Telescope.timezone);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
});

Vue.component('organisations', require('./views/Organisations'));
Vue.component('events', require('./views/Events'));
Vue.component('login', require('./views/Login'));
Vue.component('register', require('./views/Register'));

Vue.component('alert', require('./components/Alert'));

Vue.mixin(Base);

new Vue({
    el: '#app',
    router,
    data() {
        return {
            alert: {
                type: null,
                autoClose: 0,
                message: '',
                confirmationProceed: null,
                confirmationCancel: null,
            },
        }
    }
});
