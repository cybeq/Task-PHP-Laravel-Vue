<template>
  <p>{{cars}}</p>
</template>

<script>
export default {
  name: "CarsComponent",
  props:{
    cars:{
      type: Array
    }
  }
}
</script>

<style scoped>

</style>