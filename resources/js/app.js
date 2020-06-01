

require('./bootstrap');

window.Vue = require('vue');

import moment from "moment";
import App from './App.vue'
import VueRouter from 'vue-router'
import Bulma from 'bulma'
import Vuelidate from 'vuelidate'
import routes from "./routes";

Vue.use(VueRouter)
Vue.use(Bulma)
Vue.prototype.moment = moment;
Vue.use(Vuelidate)


const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
