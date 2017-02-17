/**
 * Created by lengbin on 2017/2/15.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import RouterMap from './routerMap/index';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: RouterMap
});

export default router;
