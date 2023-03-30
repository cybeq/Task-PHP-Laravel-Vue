<template>
<!--  <div v-for="client in this.list.Client" :key="client.id" >-->
<!--    {{client.name}}-->
<!--  </div>-->

 <div class="search-container">
   <IconIc svgPath="search" width="36" height="36" fillColor="orange"></IconIc>
   <input  type="search"  v-model="searchedPhrase" >
 </div>

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
import IconIc from "@/components/widgets/IconIc.vue";
export default {
  name: "ListController",
  components: {IconIc},
  data() {
    return {
      list: [],
      filteredList: [],
      searchedPhrase: undefined
    }
  },
  mounted() {
    for (let all of ['Client', 'Order', 'Car', 'Employee']) {
      service.read(all).then(res => {
        if (!res.error) {
          this.list[all] = res;
          this.filteredList[all] = res;
        }
      })
    }
  },
  watch: {
    searchedPhrase() {
      for (let all of ['Client', 'Order', 'Car', 'Employee']) {
        this.list[all] = this.filteredList[all].filter(client => {
          return client.name.includes(this.searchedPhrase)
        })
      }
    },
  }
}
</script>

<style scoped>
.list-container{
  width:100%;
  min-height: 500px;
  background: white;
  margin-top:30px;
}
.search-container{
  display: flex;
  justify-content: center;
  align-items: center;
  height:80px;
  margin-bottom:-30px;
}
.search-container input{
  width:95%;
  height:30px;
  border-radius:15px;
  border: solid 1px #00000030;
  padding-inline:20px;
  font-family: PoppinsRegular,sans-serif;
}
.search-container input:focus{
  outline: #f57445 solid 2px;
}

</style>