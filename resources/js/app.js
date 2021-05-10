require('./bootstrap');
window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import axios from 'axios';
import { routes } from './routes';
import App from './App.vue';
import { store } from './store/store';
import Vue from 'vue'
import Vuelidate from 'vuelidate'

import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
window.toastr = require('toastr')
import VueSwal from 'vue-swal'
Vue.use(VueToastr2)
Vue.use(VueRouter);
Vue.use(Vuelidate)

Vue.use(VueSwal)

const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

const app = new Vue({
    el: '#app',
    store,
    router: router,
    render: h => h(App)
});
