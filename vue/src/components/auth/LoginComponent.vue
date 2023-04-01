<template>
  <section class="login" style="flex-direction: column; gap:5px;">
    <h1 style="padding-top:150px; font-size: 2rem">Zaloguj sie</h1>
    <h1 style="color:red"> {{error}}</h1>
    <h1 style="width:100%; height:35px; background: #f57445; color: #f57445">_</h1>
    <input type="text" v-model="this.name" placeholder="name">
    <input type="text" v-model="this.password" placeholder="password">
    <button class="save" @click="login()" style="width:224px; padding-block:0;">Zaloguj</button>
  </section>
</template>
<script>
import {service} from "@/services/CrudService";
export default {
  name: "LoginComponent",
  mounted() {
    setTimeout(()=>{console.clear(); console.log('you must be logged in')},300)
  },
  data(){
    return{
      name:'mat',
      password:'1234',
      error:''
    }
  },
  methods: {
    login() {
      service.login(this.name, this.password).then(res=>{
        if(res.token){
          console.log(res)
          localStorage.setItem('token',res.token)
        }
        if(res.fail){
          this.printError('auth failed')
        }
        if(res.token){
          location.href="/";
        }
      }).catch(e => {
        console.log(e)
        this.printError('auth failed')
      });
    },
    printError(error){
      this.error = error;
      setTimeout(()=>{this.error=''},1000)
    }
  }
}
</script>

<style scoped>
.login{
  display: flex;
  justify-content: center;
  align-items: center;
  height:30vh;
}
</style>