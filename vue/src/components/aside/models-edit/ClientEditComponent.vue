<template>
  <p>Nazwa klienta</p>
  <input type="text" v-model="this.client.name">
  <p>Przypisany pracownik:</p>
    <select v-model="selectEmployee">
      <option v-for="all in this.list.Employee" :key="all.name" :value="all.id">{{all.name}}</option>
    </select>


  <p>Zamów dla klienta:</p>
  <select v-model="selectOrder">
    <option v-for="all in this.list.Order" :key="all.name" :value="all.id">{{all.name}}</option>
  </select>


  <p>Przydziel auto:</p>
  <select v-model="selectCar">
    <option v-for="all in this.list.Car" :key="all.name" :value="all.id">{{all.name}}</option>
  </select>


  <button class="save" @click="save()">Zapisz</button>


</template>

<script>
import {service} from "@/services/CrudService";

export default {
  name: "ClientEditComponent",
  props:{
    id: {
      type:String,
      required:true
    },
    model:{
      type: String,
      required:true,
    },
    list:{
      type:Array
    }
  },
  data(){
    return{
      client:{},
      selectEmployee:null,
      selectOrder:null,
      selectCar:null
    }
  },
  mounted() {
    service.read(this.model, this.id).then(model=>{
      this.client = model;
      this.selectEmployee = this.client.employee_id ?? null;
    })
  },
  methods:{
    save(){
      console.log(this.selectOrder)
      service.edit(this.model, this.id, {
        name:this.client.name,
        foreign_id: this.selectEmployee,
        order_id:this.selectOrder,
        car_id:this.selectCar
      }).then(()=>{
        location.href='/clients'
      })
    }
  }
}
</script>

<style scoped>
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