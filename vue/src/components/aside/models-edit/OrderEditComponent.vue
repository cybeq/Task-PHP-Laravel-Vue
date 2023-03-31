<template>
  <p style="font-size:0.8em;">Utworzono: {{new Date(this.order.created_at).toDateString()}}</p>

  <p style="margin-bottom:0;">Nazwa zamówienia</p>
  <input type="text" v-model="this.order.name">

  <p style="margin-bottom:0;">Cena</p>
  <input type="number" v-model="this.order.price">


  <button class="save" @click="save()">Zapisz</button>
</template>

<script>
import {service} from "@/services/CrudService";
export default {
  name: "OrderEditComponent",
  props:{
    id: {
      type:String,
      required:true
    },
    model:{
      type: String,
      required:true,
    }

  },
  data(){
    return{
      order:{},
    }
  },
  mounted() {
    service.read(this.model, this.id).then(model=>{
      this.order = model;
    })
  },
  methods:{
    save(){
      service.edit(this.model, this.id, {
        name:this.order.name,
        price:this.order.price
      }).then(()=>{
        location.reload();
      })
    }
  }
}
</script>

<style scoped>

</style>