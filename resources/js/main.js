import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import App from './App.vue'
import router from './router'
import store from './store'

Vue.use(BootstrapVue)

Vue.config.productionTip = false

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.request.use(
    (config) => {

        let user = JSON.parse(localStorage.getItem('user'))

        if (user && user.token) {
            config.headers['Authorization'] = `Bearer ${ user.token }`;
        }

        config.headers['Accept'] = 'application/json';
        config.headers['Content-Type'] = 'application/json';

        return config;
    },

    (error) => {
        return Promise.reject(error);
    }
);

router.beforeEach((to, from, next) => {

    const publicPages = ['/login', '/'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');

    if (authRequired && !loggedIn) {
        return next('/login');
    }

    next();
})

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')