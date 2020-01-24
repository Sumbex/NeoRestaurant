require('./bootstrap');

window.Vue = require('vue');

import Rutas from './rutas.js';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'jquery/dist/jquery.min.js';
import Notifications from 'vue-notification/dist/ssr.js'
Vue.use(Notifications)
import Chart from 'chart.js';

import axios from 'axios';
import VueAxios from 'vue-axios';

import App from './components/publico/outer.vue';
Vue.use(VueAxios, axios);

import VueAuth from '@websanova/vue-auth'

const router = new VueRouter({
  routes: [
    ...Rutas,
  ],
});

Vue.router = router;

App.router = Vue.router;

Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
   rolesVar: 'type',//aqui va la columna rol de users
   loginData: {url: ' api/auth/login'},
   logoutData: {url: ' api/auth/logout'},
   fetchData: {url: ' api/auth/user'},
   refreshData: {enabled: false},
});

new Vue(App).$mount('#app');