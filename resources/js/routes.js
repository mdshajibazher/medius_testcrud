import CustomerList from './components/CustomerComponent.vue';
import CustomerCreate from './components/CustomerCreateComponent.vue';
import CustomerEdit from './components/CustomerEditComponent.vue';
//import routes js
const routes = [
    {path: "/", component: CustomerList},
    {path: "/customer-list", component: CustomerList},
    {path: "/create-customer", component: CustomerCreate},
    {path: "/edit-customer/:id", component: CustomerEdit},

]

export default routes;
