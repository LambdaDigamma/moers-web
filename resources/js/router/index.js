import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
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
                import ('../views/Profile'),
            children: [
                {
                    name: 'profile-organisations',
                    path: '/profile/organisations',
                    component: () =>
                        import ('../views/Profile/ProfileOrganisations')
                },
                {
                    name: 'profile-events',
                    path: '/profile/events',
                    component: () =>
                        import ('../views/Profile/ProfileEvents')
                },
                {
                    name: 'profile-settings',
                    path: '/profile/settings',
                    component: () =>
                        import ('../views/Profile/ProfileSettings')
                }
            ]
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
            children: [
                {
                    name: 'organisation-news',
                    path: '/organisations/:id/news',
                    component: () =>
                        import ('../views/Organisation/OrganisationNews')
                },
                {
                    name: 'organisation-events',
                    path: '/organisations/:id/events',
                    component: () =>
                        import ('../views/Organisation/OrganisationEvents')
                },
                {
                    name: 'organisation-entry',
                    path: '/organisations/:id/entry',
                    component: () =>
                        import ('../views/Organisation/OrganisationEntry')
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
            name: "polls.poll",
            path: "/polls/:id",
            component: () =>
                import ('../views/Poll'),
            props: castRouteParams
        },
        {
            name: "admin",
            path: "/admin",
            component: () =>
                import('../views/Admin/AdminDashboard')
        },
        {
            name: "admin.users",
            path: "/admin/users",
            component: () =>
                import('../views/Admin/Users')
        }
    ],
    linkActiveClass: "active"
})

function castRouteParams(route) {
    return {
        id: Number(route.params.id),
    };
}