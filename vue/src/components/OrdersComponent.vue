<template>
<div v-if="this.orders">
  <div  v-for="order in orders[this.page]" :key="order.id" @click="dropDownInfo(order)">
    <div class="row"  :style="this.droppable[order.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015'">
      <div>{{order.id}}</div>
      <div>{{order.name}}</div>

      <div>{{order.price}} ,-</div>
      <div style="display: flex">
        <button class="action-button" @click="edit('delete', order)">usuń
          <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
        <button class="action-button-green" @click="edit(null, order)">edytuj
          <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
      </div>
    </div>
    <div :id="`${order.id}-droppable`"  :style="!this.droppable[order.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' " ></div>
  </div>
</div>
</template>
<script>
import IconIc from "@/components/widgets/IconIc.vue";
import {service} from "@/services/CrudService";
import router from "@/routes";

export default {
  name: "OrderComponent",
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
  data() {
    return {
      droppable: {},
    }
  },
  methods:{
    edit(option, order){
      if(option === 'delete'){
        service.delete('Order',order.id).then(response=>{
          console.log(response)
          location.reload();
        }).catch(e=>{
          console.log(e)});
        return;
      }
      router.push(`/edit/Order/${order.id}`);
    },
    dropDownInfo(order){
      const dom = document.getElementById(`${order.id}-droppable`)
      if(dom===null) return;
      if(this.droppable[order.id]){
        this.droppable[order.id] = false;
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
              <p style="font-weight: bold">Utworzony: ${new Date(order.created_at).toDateString()}</p>
         </div>
      `;
      dom.appendChild(div);

      this.droppable[order.id] = true;
    },
  }
}
</script>

<style scoped>
.row, .column{
  display: grid;
  grid-template-columns: 1fr 2fr  6fr 2fr;

}
</style>