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
        <OrderEditComponent  :model="this.model" :id="this.id"></OrderEditComponent>
      </div>
      <div v-if="this.model === 'Employee'">
        <EmployeeEditComponent :model="this.model" :id="this.id"></EmployeeEditComponent>
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

<style >
section{
  font-family: PoppinsRegular, sans-serif;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  padding: 20px;
}
.save{
  display:block;
  background: none;
  border:solid 2px orange;
  border-radius: 12px;
  padding:12px;
  margin-block: 15px;
  color:orange;
  font-family: PoppinsMedium, sans-serif;
  padding-inline: 30px;
  transition: background-color 0.6s ease, color 0.6s ease;
}
.save:hover{
  background-color: orange;
  color:white;
  cursor:pointer
}
input, select{
  padding: 3px;
  border-radius:10px;
  padding-inline: 10px;
  border: solid 1px orange;
  font-style: italic;
  background: white;
}
</style>