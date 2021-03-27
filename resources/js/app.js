console.log(123)

import Vue from 'vue'
import transport from "./plugins/axios";
// import store from "./store";

// import router from './routes/index'
import Vuetify from './plugins/vuetify' // path to vuetify export


// Vue.use(auth, config);
Vue.prototype.$axios = transport;
// Vue.use(transport);

import App from './App.vue'

const app = new Vue({
    el: '#app',
    components: { App },
    // router: router,
    vuetify: Vuetify,
    // store,
})
