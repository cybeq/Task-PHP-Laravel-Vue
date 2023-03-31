<template>

 <div class="search-container">
   <IconIc svgPath="search" width="36" height="36" fillColor="orange"></IconIc>
   <input  type="search"  v-model="searchedPhrase" >
 </div>

 <div class="list-container">

   <div class="column" v-if="this.$route.name === 'Clients'">
     <div v-on:click="filterListBy('id')" class="sortable">#</div>
     <div v-on:click="filterListBy('name')" class="sortable">Imię i nazwisko</div>
     <div v-on:click="filterListBy('orders')"  class="sortable">Łączna kwota zakupów</div>
     <div v-on:click="filterListBy('cars')" class="sortable">Liczba aut</div>
     <div>Edytuj/Usuń</div>
   </div>

   <div class="column" v-if="this.$route.name === 'Orders' ">
     <div v-on:click="filterListBy('id')" class="sortable">#</div>
     <div v-on:click="filterListBy('name')" class="sortable">Nazwa</div>
     <div v-on:click="filterListBy('price')"  class="sortable">Cena</div>
     <div></div>
     <div>Edytuj/Usuń</div>
   </div>

   <div class="column" v-if="this.$route.name === 'Employees' ">
     <div v-on:click="filterListBy('id')" class="sortable">#</div>
     <div v-on:click="filterListBy('name')" class="sortable">Imię i nazwisko</div>
     <div ></div>
     <div></div>
     <div>Edytuj/Usuń</div>
   </div>

   <div class="column" v-if="this.$route.name === 'Cars' ">
     <div v-on:click="filterListBy('id')" class="sortable">#</div>
     <div v-on:click="filterListBy('name')" class="sortable">Nazwa auta</div>
     <div ></div>
     <div></div>
     <div>Edytuj/Usuń</div>
   </div>

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
      searchedPhrase: undefined,
      isFiltered:false,
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
          return client.name.toLowerCase().includes(this.searchedPhrase.toLowerCase())
        })
      }
    },
  },
  methods:{
    summarize(client, option){
      let summary = 0;
      switch(option){
        case 'cars':
          client.cars.forEach(()=>{ summary+=1 }) ; break;
        default:
          client.orders.forEach(order=>{ summary+=order.price }); break;
      }
      return summary;
    },
    filterListBy(filter){
      if(this.isFiltered){
        for (let all of ['Client', 'Order', 'Car', 'Employee']) {
          switch(filter){
            case "orders":
              if(all === 'Client'){
                this.filteredList[all].sort((a, b) => a[filter] && b[filter] ? this.summarize(a) - this.summarize(b):null);
              }
              break;
            case "cars":
              if(all === 'Client'){
                this.filteredList[all].sort((a, b) => a[filter] && b[filter] ? this.summarize(a, 'cars') - this.summarize(b, 'cars'):null);
              }
              break;
            default:
              this.filteredList[all].sort((a, b) => filter === 'name' ? a[filter].localeCompare(b[filter]) : a[filter] - b[filter]);
              break;
          }
        }
        this.isFiltered = false;
        return
      }
      for (let all of ['Client', 'Order', 'Car', 'Employee']) {
        switch(filter){
          case "orders":
            if(all === 'Client'){
              this.filteredList[all].sort((a, b) => a[filter] && b[filter] ? this.summarize(b) - this.summarize(a):null);
            }
            break;
          case "cars":
            if(all === 'Client'){
              this.filteredList[all].sort((a, b) => a[filter] && b[filter] ? this.summarize(b, 'cars') - this.summarize(a, 'cars'):null);
            }
            break;
          default:
            this.filteredList[all].sort((a, b) => filter === 'name' ? b[filter].localeCompare(a[filter]) : b[filter] - a[filter]);
            break;

        }
      }
      this.list = this.filteredList;
      this.isFiltered = true;
    }
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
.row, .column {
  display: grid;
  grid-template-columns: 1fr 2fr 1fr 6fr 2fr;
}
.sortable:hover{
  cursor: pointer;
}
</style>