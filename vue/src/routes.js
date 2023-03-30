import { createRouter, createWebHistory } from 'vue-router'
import ClientsComponent from "@/components/ClientsComponent.vue";
import CarsComponent from "@/components/CarsComponent.vue";
import OrdersComponent from "@/components/OrdersComponent.vue";
import EmployeesComponent from "@/components/EmployeesComponent.vue";

const routes = [
    {
        path: '/clients',
        name: 'Clients',
        component: ClientsComponent,
        props:true
    },
    {
        path: '/cars',
        name: 'Cars',
        component: CarsComponent,
        props:true
    },
    {
        path: '/orders',
        name: 'Orders',
        component: OrdersComponent,
        props:true
    },
    {
        path: '/employees',
        name: 'Employees',
        component: EmployeesComponent,
        props:true
    },
    // {
    //     path: '/about',
    //     name: 'About',
    //     component: About
    // }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;