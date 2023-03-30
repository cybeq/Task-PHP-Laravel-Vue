<template>
  <div class="app-container">
    <TaskbarComponent></TaskbarComponent>
    <ListComponent></ListComponent>
  </div>
</template>

<script>
import ListComponent from "@/components/ListComponent.vue";
import TaskbarComponent from "@/components/TaskbarComponent.vue";
export default {
  name: 'App',
  components: {
    ListComponent,
    TaskbarComponent
  }
}
</script>

<style>
@font-face {
  font-family: 'PoppinsMedium';
  src: url('@/assets/fonts/Poppins-SemiBold.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
}
@font-face {
font-family: 'PoppinsRegular';
src: url('@/assets/fonts/Poppins-Regular.ttf') format('truetype');
font-weight: normal;
font-style: normal;
}


body{
  margin:0;
  padding:30px;
  background: #f3f3f3;
}
.app-container{
  min-width:100%;
  min-height:100vh;
}
.row, .column{
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  padding:10px;
  font-family: PoppinsRegular, sans-serif;
  border-bottom: 1px #00000030 solid;
  transition: background-color 0.7s ease;
}
.row:hover{
  background-color: #f5744530;

}
.action-button, .action-button-green{
  cursor: pointer;
  background: #e5440a;
  color: white;
  font-family: PoppinsRegular, sans-serif;
  border:none;
  padding:2px;
  text-align: center;
  margin-inline:10px;
  transition: box-shadow 0.5s ease, background-color 1s ease ;
}
.action-button-green{
  background: #688815;
}
.action-button:hover, .action-button-green:hover{
  box-shadow: 3px 3px 3px #00000050;
  background: black;
}
</style>
