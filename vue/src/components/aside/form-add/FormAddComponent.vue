<template>
<div v-for="input of this.form.inputs" :key="input.name">
  <p style="margin-bottom:0;">{{input.description}}</p>
  <input v-model="input.value" :type="input.type" :placeholder="input.placeholder">
</div>
<div v-for="select of this.form.selects" :key="select.name">
  <p>{{select.description}}</p>
  <select v-model="select.value">
      <option v-for="model in select.list" :key="model.id" :value="model.id">{{model.name}}</option>
  </select>
</div>
<button class="save" @click="save()">Dodaj {{ {Client:"klienta", Order:"zamówienie", Employee:"pracownika", Car:"auto"}[this.modelName] }}</button>
</template>

<script>
import {service} from "@/services/CrudService";
export default {
  name: "FormAddComponent",
  props:{
    form:{
      type:Object
    },
    modelName:{
      type:String
    },
  },
  data(){
    return {
    }
  },
  methods:{
    save(){
      const body = {};
      for(let input of this.form.inputs){
        body[input.name] = input.value
      }
      for(let select of this.form.selects){
        body[select.name] = select.value
      }
      console.log(body)

      if(this.form.method === 'create')
      service.create(this.modelName, body).then(res=>{
        console.log(res)
        location.href=`/${ {Client:"clients", Order:"orders", Employee:"employees", Car:"cars"}[this.modelName] }`
      })
    }
  }
}
</script>

<style scoped>

</style>