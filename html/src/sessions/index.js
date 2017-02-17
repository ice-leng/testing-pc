/**
 * Created by lengbin on 2017/2/15.
 */

import Vue from 'vue';
import Vuex from 'vuex';
import config from './moudels/config';

Vue.use(Vuex);

const session = new Vuex.Store({
    modules: {
        config
    }
});

export default session;

