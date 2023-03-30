<template>
  <div></div>
</template>

<script>
import {service} from '../services/CrudService'
export default {
  name: "ListController",
  data(){
    return{
      list:undefined,
      clients:undefined,
      orders:undefined,
      cars:undefined,
      employees:undefined
    }
  },
  mounted(){
    for(let all of ['Client', 'Order', 'Car', 'Employee'])
    service.read(all, 5).then(res=>{
      if(!res.error) {
        this[all] = res;
        console.log(this[all])
      }
    })




  }
}
</script>

<style scoped>

</style>