require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue'
//vue router
import VueRouter from 'vue-router'
//V form
import { Form, HasError, AlertError } from 'vform'
window.Form = Form

//vue progressbar
import VueProgressBar from 'vue-progressbar'



//sweet alert 2
require('./sweetlaert')


const progressbaroptions = {
    color: '#44bd32',
    failedColor: '#eb2f06',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}
Vue.use(VueProgressBar, progressbaroptions)
Vue.use(VueRouter)
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
//Vue.component('pagination', require('laravel-vue-pagination'));



import routes from './routes'
//require('./routes.js');

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router
});
