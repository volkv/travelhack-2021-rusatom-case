import Vuex from 'vuex';
import Vue from 'vue';

import { resourceModule } from '@reststate/vuex';
import transport from "../plugins/axios";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        events: resourceModule({name: 'events',httpClient: transport}),
        places: resourceModule({name: 'places',httpClient: transport}),
        trips: resourceModule({name: 'trips',httpClient: transport}),
    },
});

export default store
