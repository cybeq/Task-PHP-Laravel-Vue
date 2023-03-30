<template>
  <p>{{orders}}</p>
</template>

<script>
export default {
  name: "OrderComponent",
  props:{
    orders:{
      type:Array
    }
  }
}
</script>

<style scoped>

</style>