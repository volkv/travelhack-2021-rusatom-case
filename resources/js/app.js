console.log(123)

import Vue from 'vue'
import transport from "./plugins/axios";
import store from "./store";
import router from "./plugins/router";
import Vuetify from './plugins/vuetify' // path to vuetify export
import Toasted from 'vue-toasted';

Vue.use(Toasted)

Vue.prototype.$axios = transport;

import App from './App.vue'

const app = new Vue({
    el: '#app',
    components: { App },
    router: router,
    vuetify: Vuetify,
    store,
})
