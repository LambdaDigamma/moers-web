import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import Events from './views/Events.vue'
import EventDetail from './views/EventDetail.vue'
import Organisations from './views/Organisations.vue'
import OrganisationsDetail from './views/OrganisationsDetail.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/organisations/:id',
            name: 'organisation-detail',
            component: OrganisationsDetail
        },
        {
            path: '/organisations',
            name: 'organisations',
            component: Organisations
        },
        {
            path: '/events/:id',
            name: 'event-detail',
            component: EventDetail
        },
        {
            path: '/events',
            name: 'events',
            component: Events
        }
    ]
})