<template>
  <p style="font-size:0.8em;">Utworzono: {{new Date(this.car.created_at).toDateString()}}</p>

  <p style="margin-bottom:0;">Nazwa auta</p>
  <input type="text" v-model="this.car.name">
  <p style="margin-bottom:0;">Klienci do których przypisane jest auto:</p>

  <p style="font-size:0.7em; margin-bottom:0">Dodaj</p>
  <select v-model="this.selectClient" style="border-width: 2px; border-radius: 12px; height:fit-content; margin-rigt:30px; display: inline; border-top-right-radius: 0; border-bottom-right-radius: 0">
    <option v-for="client of this.list.Client" :key="client.id" :value="client.id">{{client.name}}</option>
  </select>



  <ul>
    <li  v-for="client in this.car.clients" :key="client.id">{{client.name}}</li>
  </ul>

  <button class="save" @click="save()">Zapisz</button>

</template>

<script>
import {service} from "@/services/CrudService";
export default {
  name: "CarEditComponent",
  props:{
    id: {
      type:String,
      required:true
    },
    model:{
      type: String,
      required:true,
    },
    list:{}
  },
  data(){
    return{
      car:{},
      selectClient:null
    }
  },
  mounted() {
    service.read(this.model, this.id).then(model=>{
      this.car = model;
      console.log(model)
    })
  },
  methods:{
    save(){
      console.log(this.selectClient)
      service.edit(this.model, this.id, {
        name:this.car.name,
        foreign_id: this.selectClient
      }).then(()=>{
        location.reload();
      })
    }
  }
}
</script>

<style scoped>

</style>