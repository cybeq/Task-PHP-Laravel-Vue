<template>

 <div class="search-container">
   <IconIc svgPath="search" width="36" height="36" fillColor="orange"></IconIc>
   <input  type="search"  v-model="searchedPhrase" >
 </div>
 <div style="display: flex;justify-content: center; margin-top:20px;">
   <button class="save" @click="add()" v-if="this.$route.path.replaceAll('/', '') === 'clients'
                                            || this.$route.path.replaceAll('/', '') === 'orders'
                                            || this.$route.path.replaceAll('/', '') === 'employees'
                                            || this.$route.path.replaceAll('/', '') === 'cars'
    ">
     Dodaj
   </button>
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
       :page      = this.page
   />


   <div class="pagination" v-if="['clients','orders','employees', 'cars'].filter(res => res === this.$route.path.replaceAll('/', '')).length>0">
     <div class="pagination-arrow" @click="moveToPage('backward')">
       <IconIc svgPath="arrow-left" width="26" height="26" fillColor="#fff"></IconIc>
     </div>
     <div style="font-family:PoppinsMedium; display:flex; justify-content: center; align-items: center; border-bottom:1px solid #00000015">
       {{page+1}}
     </div>
     <div class="pagination-arrow" @click="moveToPage('forward')">
       <IconIc svgPath="arrow-right" width="26" height="26" fillColor="#fff"></IconIc>
     </div>
   </div>
 </div>
</template>

<script>
import {service} from '../services/CrudService'
import IconIc from "@/components/widgets/IconIc.vue";
import router from "@/routes";
export default {
  name: "ListController",
  components: {IconIc},
  data() {
    return {
      list: [],
      filteredList: [],
      paginatedList:[],
      searchedPhrase: undefined,
      isFiltered:false,
      maxItemsOnPage:10,
      page:0
    }
  },
  mounted() {
    let loadedServices = 0;
    for (let all of ['Client', 'Order', 'Car', 'Employee']) {
      service.read(all).then(res => {
        if (!res.error) {
          this.list[all] = res;
          this.filteredList[all] = res;
        }
      }).finally(()=>{
        loadedServices++;
        if(loadedServices === 4)
        {
          this.paginate(this.list);
        }
      })
    }
    router.beforeEach((to, from, next) => { this.page=0 ; next(); });
  },
  watch: {
    searchedPhrase() {
      const searchedList = {};
      for (let all of ['Client', 'Order', 'Car', 'Employee']) {
        if(!searchedList[all]) searchedList[all] = [];
        for (let single of this.filteredList[all]) {
          searchedList[all].push( ( single.filter(client => { return client.name.toLowerCase().includes(this.searchedPhrase.toLowerCase()) })))
        }
      }
      this.list= searchedList
    },
  },
  methods:{
    add(){
      this.path = this.$route.path.replaceAll('/', '');
      if(this.path === 'orders' || this.path ==='clients' || this.path === 'cars' || this.path === 'employees')
      router.push(`/create/${this.path}`)
    },
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
                for(let single of this.filteredList[all] )
                single.sort((a, b) => a[filter] && b[filter] ? this.summarize(a) - this.summarize(b):null);
              }
              break;
            case "cars":
              if(all === 'Client'){
                for(let single of this.filteredList[all] )
                single.sort((a, b) => a[filter] && b[filter] ? this.summarize(a, 'cars') - this.summarize(b, 'cars'):null);
              }
              break;
            default:
              for(let single of this.filteredList[all] )
              single.sort((a, b) => filter === 'name' ? a[filter].localeCompare(b[filter]) : a[filter] - b[filter]);
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
              for(let single of this.filteredList[all] )
              single.sort((a, b) => a[filter] && b[filter] ? this.summarize(b) - this.summarize(a):null);
            }
            break;
          case "cars":
            if(all === 'Client'){
              for(let single of this.filteredList[all] )
              single.sort((a, b) => a[filter] && b[filter] ? this.summarize(b, 'cars') - this.summarize(a, 'cars'):null);
            }
            break;
          default:
            for(let single of this.filteredList[all] )
            single.sort((a, b) => filter === 'name' ? b[filter].localeCompare(a[filter]) : b[filter] - a[filter]);
            break;

        }
      }
      this.list = this.filteredList;
      this.isFiltered = true;
    },
    paginate(list){
      this.paginatedList = [];
      for (let all of ['Client', 'Order', 'Car', 'Employee']) {
        for (let i = 0; i < list[all].length; i += this.maxItemsOnPage) {
          if(!this.paginatedList[all]) {
            this.paginatedList[all] = []
          }
          this.paginatedList[all].push(list[all].slice(i, i + this.maxItemsOnPage));
        }
      }
      this.list = this.paginatedList;
      this.filteredList = this.list
    },
    moveToPage(direction){
      if(direction === 'forward'){
        const arrLength = this.list[{cars:'Car', orders:'Order', employees:'Employee', clients:'Client'}[this.$route.path.replace('/','')]].length;

        if(arrLength > this.page +1)
        this.page++;
        console.log(arrLength, this.page +1)
        return;
      }
      if(direction === 'backward'){
        if(this.page>0)
        this.page--;
        return;
      }
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
.pagination{
  display: grid;
  grid-template-columns: 1fr 10fr 1fr;
  width:100%;
  height:35px;
}
.pagination-arrow{
  background:#f57445;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: background-color 1s ease;
  cursor: pointer;
}
.pagination-arrow:hover{
  background: #914225;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>