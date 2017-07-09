// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './views/App';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import Routers from 'routers/index';
import Sessions from 'sessions/index';
import 'assets/css/reset.scss';
import 'assets/css/main.scss';
import VueResource from 'vue-resource';
import './filters/index.js';

Vue.use(ElementUI);
Vue.use(VueResource);

/* eslint-disable no-new */
new Vue({
    template: '<App/>',
    components: {App},
    router: Routers,
    store: Sessions
}).$mount('#app');

