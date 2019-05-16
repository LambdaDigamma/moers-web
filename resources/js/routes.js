export default [
    {
        path: '/organisations',
        name: 'organisations',
        component: require('./views/Organisations')
    },
    {
        path: '/organisations/:id',
        name: 'organisation-detail',
        component: require('./views/OrganisationsDetail')

    },
    {
        path: '/events',
        name: 'events',
        component: require('./views/Events')
    },
    {
        path: '/login',
        name: 'login',
        component: require('./views/Login')
    },
    {
        path: '/register',
        name: 'register',
        component: require('./views/Register')
    }
];