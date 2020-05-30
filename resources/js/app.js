require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import moment from 'moment';
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios';
import VModal from 'vue-js-modal'
import axios from 'axios';
import VueSlideoutPanel from 'vue2-slideout-panel';

moment.locale('pt-br');

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VModal);
Vue.use(VueSlideoutPanel);
Vue.use(require('vue-truncate-filter'));
Vue.use(require('vue-moment'), {
    moment,
});

import App from './views/App'
import Auth from './views/Auth'
import Login from './views/Login'
import Home from './views/Home'
import Hello from './views/Home/Hello'
import Feed from './views/Home/Feed'
import Index from './views/Home/Index'
import NaoEncontrado from './views/NaoEncontrado'

import auth from '@websanova/vue-auth';
import authBearer from '@websanova/vue-auth/dist/drivers/auth/bearer.js';
import httpAxios from '@websanova/vue-auth/dist/drivers/http/axios.1.x.js';
import routerVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.js';

axios.defaults.baseURL = API_URL;

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '*',
            name: 'not-found',
            component: NaoEncontrado
        },
        {
            path: '/auth',
            name: 'auth',
            component: Auth
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false
            }
        },
        {
            path: '',
            name: 'home',
            component: Home,
            meta: {
                auth: true
            },
            children: [
                {
                    path: '',
                    name: 'home.index',
                    component: Index,
                },
                {
                    path: 'feed/:id',
                    name: 'home.feed',
                    component: Feed,
                },
                {
                    path: 'hello',
                    name: 'home.hello',
                    component: Hello,
                },
            ],
        },
    ],
});

Vue.router = router;

Vue.use(auth, {
    auth: authBearer,
    http: httpAxios,
    router: routerVueRouter
});

const app = new Vue({
    el: '#app',
    components: { App },
    router
});
