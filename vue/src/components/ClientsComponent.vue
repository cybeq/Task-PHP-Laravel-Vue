<template>
  <div v-if="this.clients">
    <div  v-for="client in clients[this.page]" :key="client" @click="dropDownInfo(client)">
      <div v-if="client">
        <div class="row" :style="this.droppable[client.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' ">
            <div>{{client.id}}</div>
            <div>{{client.name}}</div>
            <div>{{this.summarize(client)}}</div>
            <div>{{this.summarize(client,'cars')}}</div>
            <div style="display: flex">
              <button class="action-button" @click="edit('delete', client)">usuń
                  <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
              </button>
              <button class="action-button-green" @click="edit(null, client)">edytuj
                <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
              </button>
            </div>
        </div>
        <div :id="`${client.id}-droppable`" :style="!this.droppable[client.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' " ></div>
      </div>
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
    },
    page:Number

  },
  data(){
    return{
        droppable:{},
        signedEmployee:{},
        ignorable:null,

    }
  },
  mounted() {

  },
  methods:{
    edit(option, client){
      if(option === 'delete'){
        service.delete('Client',client.id).then(response=>{
          console.log(response)
          location.reload();
        }).catch(e=>{
          console.log(e)});
        return;
      }
      router.push(`/edit/Client/${client.id}`);
    },
    dropDownInfo(client){
      for(let employee of this.employees){
        try {
          this.signedEmployee = employee.find(employee => {
            return employee.id === client.employee_id
          }).name
        }catch(_){
          this.ignorable = _;
        }
          if(this.signedEmployee) break;
      }

      const dom = document.getElementById(`${client.id}-droppable`)
      if(dom===null) return;
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
              <p style="font-weight: bold">Przypisany pracownik: ${client.employee_id ? this.signedEmployee : 'brak'}</p>
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
          try { client.cars.forEach(() => { summary += 1 }); }catch (_) { this.ignorable = _ }
          break;

        default:
          try{ client.orders.forEach(order=>{ summary+=order.price });  } catch(_){ this.ignorable = _ }
          break;
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