<template>
  car edit {{this.id}}
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
    }

  },
  data(){
    return{
      car:{}
    }
  },
  mounted() {
    service.read(this.model, this.id).then(model=>{
      this.car = model;
    })
  }
}
</script>

<style scoped>

</style>