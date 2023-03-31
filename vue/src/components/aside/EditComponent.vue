<template>
<section>
  <h1>{{translatable[model] }} {{this.editableModel.name}}</h1>

  <div v-if="this.model === 'Client'">
    client
  </div>
  <div v-if="this.model === 'Car'">
    car
  </div>
  <div v-if="this.model === 'Order'">
    ord
  </div>
  <div v-if="this.model === 'Employee'">
    emp
  </div>

</section>

</template>

<script>
import {service} from "@/services/CrudService";

export default {
  name: "EditComponent",
  data(){
    return{
      list:[],
      translatable: {Client:"Klient", Car:"Auto", Order:"Zamówienie", Employee:"Pracownik"},
      editableModel: {},
    }
  },
  mounted() {
      service.read(this.model).then(res => {
        if (!res.error) {
          this.list[this.model] = res;
            this.editableModel = this.list[this.model].find(model => model.id === parseInt(this.id))
        }
      })
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