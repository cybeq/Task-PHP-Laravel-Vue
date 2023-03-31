<template>
  order edit {{this.id}}
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
      order:{}
    }
  },
  mounted() {
    service.read(this.model, this.id).then(model=>{
      this.order = model;
    })
  }
}
</script>

<style scoped>

</style>