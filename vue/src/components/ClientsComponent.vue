<template>


  <div class="client-container">

    <div class="column">
        <div>id</div>
        <div>Imię i nazwisko</div>
        <div>Edytuj/Usuń</div>
    </div>
    <div class="row" v-for="client in clients" :key="client.id">
      <div>{{client.id}}</div>
      <div>{{client.name}}</div>
      <div style="display: flex">
        <button class="action-button">
            <IconIc svgPath="trash" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
        <button class="action-button-green">
          <IconIc svgPath="edit" width="26" height="26" fillColor="#fff"></IconIc>
        </button>
      </div>
    </div>
  </div>

</template>

<script>
import IconIc from "@/components/widgets/IconIc.vue";
export default {
  name: "ClientsComponent",
  components:{IconIc},
  props:{
    clients:{
      type: Array
    }
  }
}
</script>

<style scoped>
.row, .column{
  display: grid;
  grid-template-columns: 1fr 10fr 2fr;
}
.column{
  background-color: #f57445;
  color:white;
}
</style>