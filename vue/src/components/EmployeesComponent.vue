<template>
  <div  v-for="client in employees" :key="client.id" >
    <div class="row">
      <div>{{client.id}}</div>
      <div>{{client.name}}</div>

      <div></div>
      <div style="display: flex">
        <button class="action-button" >
          <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
        <button class="action-button-green">
          <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
      </div>
    </div>
    <div :id="`${client.id}-droppable`"  ></div>
  </div>
</template>

<script>
import IconIc from "@/components/widgets/IconIc.vue";
export default {
  name: "EmployeesComponent",
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
  }
}
</script>

<style scoped>
.row, .column{
  display: grid;
  grid-template-columns: 1fr 2fr  6fr 2fr;

}
</style>