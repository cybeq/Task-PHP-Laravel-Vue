<template>
  <div  v-for="employee in employees" :key="employee.id" @click="dropDownInfo(employee)">
    <div class="row"  :style="this.droppable[employee.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015'">
      <div>{{employee.id}}</div>
      <div>{{employee.name}}</div>
      <div></div>
      <div style="display: flex">
        <button class="action-button" @click="edit('delete', employee)">usuń
          <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
        <button class="action-button-green" @click="edit(null, employee)">edytuj
          <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
      </div>
    </div>
    <div :id="`${employee.id}-droppable`"  :style="!this.droppable[employee.id] ? 'border-bottom:none' : 'border-bottom:solid 1px #00000015' " ></div>
  </div>
</template>
<script>
import IconIc from "@/components/widgets/IconIc.vue";
import {service} from "@/services/CrudService";
import router from "@/routes";

export default {
  name: "EmployeeComponent",
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
  data() {
    return {
      droppable: {},
    }
  },
  methods:{
    edit(option, employee){
      if(option === 'delete'){
        service.delete('Employee',employee.id).then(response=>{
          console.log(response)
          location.reload();
        }).catch(e=>{
          console.log(e)});
        return;
      }
      router.push(`/edit/Employee/${employee.id}`);
    },
    dropDownInfo(employee){
      const dom = document.getElementById(`${employee.id}-droppable`)
      if(dom===null) return;
      if(this.droppable[employee.id]){
        this.droppable[employee.id] = false;
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
              <p style="font-weight: bold">Utworzony: ${new Date(employee.created_at).toDateString()}</p>

         </div>
      `;
      dom.appendChild(div);

      this.droppable[employee.id] = true;
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