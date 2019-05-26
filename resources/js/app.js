import Vue from 'vue';
import Base from './base';
import axios from 'axios';
import Routes from './routes';
import VueRouter from 'vue-router'

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.use(VueRouter);

window.Popper = require('popper.js').default;

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
});

Vue.component('organisations', require('./views/Organisations'));
Vue.component('events', require('./views/Events'));
Vue.component('login', require('./views/Login'));
Vue.component('register', require('./views/Register'));

Vue.mixin(Base);

new Vue({
    el: '#app',
    router,
    data() {
        return {

        }
    }
});
