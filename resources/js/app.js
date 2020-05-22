require('./bootstrap');

window.Vue = require('vue');

//integrate
const feather = require('feather-icons');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'

import Auth from './views/Auth'
import Login from './views/Login'

import Home from './views/Home'
import Hello from './views/Home/Hello'
import Index from './views/Home/Index'

import NaoEncontrado from './views/NaoEncontrado'

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
            component: Login
        },
        {
            path: '',
            name: 'home',
            component: Home,
            children: [
                {
                    path: '',
                    name: 'home.index',
                    component: Index,
                },
                {
                    path: 'hello',
                    name: 'home.hello',
                    component: Hello,
                },
            ]
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

//call
 feather.replace();
