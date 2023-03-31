<template>
  <section class="add-container">

    <div v-if="this.model==='cars'">
        cars
    </div>

    <div v-if="this.model==='orders'">
         orders
    </div>

    <div v-if="this.model==='employees'">
        employees
    </div>

    <div v-if="this.model==='clients'">
      clients
    </div>

  </section>
</template>

<script>
export default {
  name: "AddComponent",
  props:{
    model:{
      type:String
    }
  }
}
</script>

<style scoped>

</style>