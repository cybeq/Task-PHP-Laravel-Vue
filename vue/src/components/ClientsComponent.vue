<template>
  <router-view
      :clients   = "this.clients"
      :employees = "this.employees"
      :orders    = "this.orders"
      :cars      = "this.cars"
  ></router-view>
  <div class="client-container">

    <div class="column">
        <div class="sortable">id</div>
        <div class="sortable">Imię i nazwisko</div>
        <div>Łączna wota zakupów</div>
        <div>Liczba aut</div>
        <div>Edytuj/Usuń</div>
    </div>
    <div  v-for="client in clients" :key="client.id" @click="dropDownInfo(client)">

        <div class="row" :style="this.droppable[client.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' ">
            <div>{{client.id}}</div>
            <div>{{client.name}}</div>
            <div>{{this.summarize(client)}}</div>
            <div>{{this.summarize(client,'cars')}}</div>
            <div style="display: flex">
              <button class="action-button" @click="edit('delete', client)">
                  <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
              </button>
              <button class="action-button-green" @click="edit(null, client)">
                <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
              </button>
            </div>
        </div>
        <div :id="`${client.id}-droppable`" :style="!this.droppable[client.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' " ></div>
    </div>
  </div>

</template>

<script>
import IconIc from "@/components/widgets/IconIc.vue";
import getOrdersDOM from '@/components/actions/getOrdersDOM'
import {service} from "@/services/CrudService";
import router from "@/routes";
export default {
  name: "ClientsComponent",
  components:{IconIc},
  props:{
    clients:{
      type: Array
    },
    employees:{
      type: Array
    },
    orders:{
      type:Array
    },
    cars:{
      type:Array
    }
  },
  data(){
    return{
        droppable:{},
    }
  },
  methods:{
    edit(option, client){
      if(option === 'delete'){
        service.delete('Client',client.id).then(response=>{
          console.log(response)
          location.reload();
        }).catch(e=>{
          console.log(e)});
      }
      router.push('edit');
    },
    dropDownInfo(client){
      const dom = document.getElementById(`${client.id}-droppable`)
      const ordersDomElement = getOrdersDOM(client)
      if(this.droppable[client.id]){
        this.droppable[client.id] = false;
        dom.innerHTML='';
        return;
      }

      const div = document.createElement('div');
      div.style.cursor='inherit'
      div.style.pointerEvents='none'
      div.classList.add('row')
      div.style.fontSize="0.9em";
      div.style.paddingInline="40px";
      div.innerHTML=`
         <span></span>
         <div>
              <p style="font-weight: bold">Utworzony: ${new Date(client.created_at).toDateString()}</p>
              <p style="font-weight: bold">Przypisany pracownik: ${client.employee_id ? this.employees.find(employee => {return employee.id === client.employee_id}).name : 'brak'}</p>
              <p style="font-weight: bold">Lista zakupów:</p>
         </div>
      `;
      div.innerHTML+=ordersDomElement.innerHTML ==='' ? "brak zakupionych produktów" :ordersDomElement.innerHTML;
      dom.appendChild(div);

      this.droppable[client.id] = true;
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
    }
  }
}
</script>

<style scoped>
.row, .column{
  display: grid;
  grid-template-columns: 1fr 2fr 1fr 6fr 2fr;

}



</style>