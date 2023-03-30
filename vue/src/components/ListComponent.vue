<template>
<!--  <div v-for="client in this.list.Client" :key="client.id" >-->
<!--    {{client.name}}-->
<!--  </div>-->
 <div class="list-container">
   <router-view
       :clients   = "this.list.Client"
       :orders    = "this.list.Order"
       :cars      = "this.list.Car"
       :employees = "this.list.Employee"
   />
 </div>
</template>

<script>
import {service} from '../services/CrudService'
export default {
  name: "ListController",
  data(){
    return{
      list:[],
    }
  },
  mounted(){
    for(let all of ['Client', 'Order', 'Car', 'Employee']) {
      service.read(all).then(res => {
        if (!res.error) {
          this.list[all] = res;
          console.log(res)
        }
      })
    }
  },
}
</script>

<style scoped>
.list-container{
  width:100%;
  min-height: 500px;
  background: white;
  margin-top:30px;
}

</style>