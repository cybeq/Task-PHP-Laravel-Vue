import { createRouter, createWebHistory } from 'vue-router'
import ClientsComponent from "@/components/ClientsComponent.vue";
import CarsComponent from "@/components/CarsComponent.vue";
import OrdersComponent from "@/components/OrdersComponent.vue";
import EmployeesComponent from "@/components/EmployeesComponent.vue";
import EditComponent from "@/components/aside/EditComponent.vue";
import AddComponent from "@/components/aside/AddComponent.vue";

const routes = [
    {
        path: '/',
        redirect: '/clients',
    },
    {
        path:'/create/:section',
        props:true,
        component: AddComponent
    },
    {
        path:'/edit/:model/:id',
        name:'edit',
        component:EditComponent,
        props: true

    },
    {
        path: '/clients',
        name: 'Clients',
        component: ClientsComponent,
        props:true,
        children:[]
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
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;