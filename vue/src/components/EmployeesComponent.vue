<template>
  <p>{{employees}}</p>
</template>

<script>
export default {
  name: "EmployeesComponent",
  props:{
    employees:{
      type:Array
    }
  }
}
</script>

<style scoped>

</style>