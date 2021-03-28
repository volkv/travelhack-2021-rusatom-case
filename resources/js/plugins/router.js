import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Index from '../pages/index'
import Events from '../pages/events'
import Places from '../pages/places'
import Trips from '../pages/trips'

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index,
        },
        {
            path: '/events',
            name: 'events',
            component: Events,
        },
        {
            path: '/places',
            name: 'places',
            component: Places,
        },
        {
            path: '/trips',
            name: 'trips',
            component: Trips,
        },
    ]
});


export default router
