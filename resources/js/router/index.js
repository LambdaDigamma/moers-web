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
                import ('../views/Home')
        },
        {
            name: 'login',
            path: '/login',
            component: () =>
                import ('../views/Login')
        },
        {
            name: 'profile',
            path: '/profile',
            component: () =>
                import ('../views/Home')
        },
        {
            name: 'organisations',
            path: '/organisations',
            component: () =>
                import ('../views/Organisations')
        },
        {
            name: 'organisation',
            path: '/organisations/:id',
            component: () =>
                import ('../views/Organisation'),
            props: castRouteParams,
            children: [{
                    name: 'organisation-news',
                    path: '/organisations/:id/news',
                    component: () =>
                        import ('../views/OrganisationNews')
                },
                {
                    name: 'organisation-events',
                    path: '/organisations/:id/events',
                    component: () =>
                        import ('../views/OrganisationEvents')
                },
                {
                    name: 'organisation-entry',
                    path: '/organisations/:id/entry',
                    component: () =>
                        import ('../views/OrganisationEntry')
                }
            ]
        },
        {
            name: 'events',
            path: '/events',
            component: () =>
                import ('../views/Events')
        },
        {
            name: 'polls',
            path: '/polls',
            component: () =>
                import ('../views/Polls')
        },
        {
            name: "poll",
            path: "/polls/:id",
            component: () =>
                import ('../views/Poll'),
            props: castRouteParams
        },
    ],
    linkActiveClass: "active"
})

function castRouteParams(route) {
    return {
        id: Number(route.params.id),
    };
}