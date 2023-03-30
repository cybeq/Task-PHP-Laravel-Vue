<template>
  <div class="taskbar">
      <div class="logo">
        <IconIc svgPath="activity" width="56" height="56" fillColor="#fff"></IconIc>
      </div>
      <div class="tasks">
        <span v-for="menu in this.menu" :key="menu.name">
        <router-link :to="`/${menu.route}`">
          <button >
            {{menu.value}}
          </button>
          </router-link>
          </span>
      </div>
  </div>
  <div class="active-tab">

  </div>
</template>

<script>
import IconIc from "@/components/widgets/IconIc.vue";
export default {
  name: "TaskbarComponent",
  components:{IconIc},
  data(){
    return {
      menu:[
            {name:"Client", route:'clients', value:"Klienci", icon:"users"},
            {name:"Order", route:'orders', value:"Zamówienia", icon:"trello"},
            {name:"Employee",route:'employees', value:"Pracownicy", icon:"crosshair"},
            {name:"Car", route:'cars', value:"Pojazdy", icon:"truck"}
      ],
    }
  }
}
</script>

<style scoped>
.taskbar{
  width:100%;
  height:80px;
  background: #fff;
  display: grid;
  grid-template-columns: 1fr 6fr;
}
.taskbar *{
  width:100%;
  height:100%;
}
.taskbar .logo{
  background: #f57445;
}
.taskbar .tasks{
  font-family: PoppinsRegular, sans-serif;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
}
.taskbar button{
  width:100%;
  border:none;
  font-family: PoppinsMedium,sans-serif;
  font-size:1.1em;
  cursor:pointer;
}
</style>