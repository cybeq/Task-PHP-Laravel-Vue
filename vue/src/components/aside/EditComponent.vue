<template>
<section>
  <h1>{{translatable[model] }}</h1>
      <div v-if="this.model === 'Client'">
        <ClientEditComponent :list="this.list" :model="this.model" :id="this.id"></ClientEditComponent>
      </div>
      <div v-if="this.model === 'Car'">
        <CarEditComponent  :list="this.list" :model="this.model" :id="this.id"></CarEditComponent>
      </div>
      <div v-if="this.model === 'Order'">
        <OrderEditComponent :list="this.list" :model="this.model" :id="this.id"></OrderEditComponent>
      </div>
      <div v-if="this.model === 'Employee'">
        <EmployeeEditComponent :list="this.list" :model="this.model" :id="this.id"></EmployeeEditComponent>
      </div>
</section>

</template>

<script>
import {service} from "@/services/CrudService";
import ClientEditComponent from "@/components/aside/models-edit/ClientEditComponent.vue";
import CarEditComponent from "@/components/aside/models-edit/CarEditComponent.vue";
import EmployeeEditComponent from "@/components/aside/models-edit/EmployeeEditComponent.vue";
import OrderEditComponent from "@/components/aside/models-edit/OrderEditComponent.vue";
export default {
  name: "EditComponent",
  components:{
    ClientEditComponent,
    CarEditComponent,
    EmployeeEditComponent,
    OrderEditComponent
  },
  data(){
    return{
      list:[],
      translatable: {Client:"Klient", Car:"Auto", Order:"Zamówienie", Employee:"Pracownik"},
    }
  },
  mounted() {
        for (let all of ['Client', 'Order', 'Car', 'Employee']) {
        service.read(all).then(res => {
          if (!res.error) {
            this.list[all] = res;
          }
        })
      }
  },
  props:{
    id:{
      type:String,
      required: true
    },
    model:{
      type:String,
      required:true
    },
  },
}
</script>

<style scoped>
section{
  font-family: PoppinsRegular, sans-serif;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  padding: 20px;
}
</style>