import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [{
            name: 'home',
            path: '/',
            component: () =>
                import ('./views/Home')
        },
        {
            name: 'login',
            path: '/login',
            component: () =>
                import ('./views/Login')
        },
        {
            name: 'profile',
            path: '/profile',
            component: () =>
                import ('./views/Home')
        },
        {
            name: 'organisations',
            path: '/organisations',
            component: () =>
                import ('./views/Organisations')
        },
        {
            name: 'events',
            path: '/events',
            component: () =>
                import ('./views/Events.vue')
        }
    ],
    linkActiveClass: "active"
})