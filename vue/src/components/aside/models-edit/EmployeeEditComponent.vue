<template>
  <p style="font-size:0.8em;">Utworzono: {{new Date(this.employee.created_at).toDateString()}}</p>

  <p style="margin-bottom:0;">Nazwa pracownika</p>
  <input type="text" v-model="this.employee.name">


  <button class="save" @click="save()">Zapisz</button>
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
  },
  methods:{
    save(){
      service.edit(this.model, this.id, {
        name:this.employee.name
      }).then(()=>{
        location.reload();
      })
    }
  }
}
</script>

<style scoped>

</style>