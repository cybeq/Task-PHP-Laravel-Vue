<template>
  employee edit {{this.id}}
</template>

<script>
import {service} from "@/services/CrudService";
export default {
  name: "EmployeeEditComponent",
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
      employee:{}
    }
  },
  mounted() {
    service.read(this.model, this.id).then(model=>{
      this.employee = model;
    })
  }
}
</script>

<style scoped>

</style>