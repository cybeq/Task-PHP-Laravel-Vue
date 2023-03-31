<template>
  <div  v-for="car in cars" :key="car.id" @click="dropDownInfo(car)">
    <div class="row"  :style="this.droppable[car.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015'">
      <div>{{car.id}}</div>
      <div>{{car.name}}</div>
      <div></div>
      <div style="display: flex">
        <button class="action-button" @click="edit('delete', car)">usuń
          <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
        <button class="action-button-green" @click="edit(null, car)">edytuj
          <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
      </div>
    </div>
    <div :id="`${car.id}-droppable`"  :style="!this.droppable[car.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' " ></div>
  </div>
</template>
<script>
import IconIc from "@/components/widgets/IconIc.vue";
import {service} from "@/services/CrudService";
import router from "@/routes";

export default {
  name: "CarsComponent",
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
  },
  mounted(){
    console.log(this.cars)
  },
  data() {
    return {
      droppable: {},
    }
  },
  methods:{
    edit(option, car){
      if(option === 'delete'){
        service.delete('Car',car.id).then(response=>{
          console.log(response)
          location.reload();
        }).catch(e=>{
          console.log(e)});
        return;
      }
      router.push(`/edit/Car/${car.id}`);
    },
    dropDownInfo(car){
      const dom = document.getElementById(`${car.id}-droppable`)
      if(dom===null) return;
      if(this.droppable[car.id]){
        this.droppable[car.id] = false;
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
              <p style="font-weight: bold">Utworzony: ${new Date(car.created_at).toDateString()}</p>
         </div>
      `;
      dom.appendChild(div);

      this.droppable[car.id] = true;
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