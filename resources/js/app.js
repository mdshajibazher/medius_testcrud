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
//Vue.component('customercreate-component', require('./components/CustomerCreateComponent.vue').default);
//Vue.component('customeredit-component', require('./components/CustomerEditComponent.vue').default);
// Vue.component( CustomerList, require('./components/CustomerComponent.vue').default);





Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);



const customerList = require('./components/CustomerComponent.vue').default;
const customerCreate = require('./components/CustomerCreateComponent.vue').default;
const customerEdit = require('./components/CustomerEditComponent.vue').default;
//import routes js
const routes = [
    {path: "/", component: customerList},
    {path: "/customerlist", component: customerList},
    {path: "/createcustomer", component: customerCreate},
    {path: "/editcustomer/:id", component: customerEdit},

]



const router = new VueRouter({
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router
});
