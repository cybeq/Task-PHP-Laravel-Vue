<template>
  <section class="add-container">

    <div v-if="this.section==='cars'">
        <FormAddComponent
                          :modelName="this.modelName"
                          :form="{
                                  method:'create',
                                  inputs: [
                                            {
                                              name:'name',
                                              description:'Marka i nazwa auta',
                                              type:'text',
                                              value:'',
                                              placeholder:'Wpisz nazwę auta'
                                            },
                                  ],
                                  selects: [
                                             {
                                               name:'foreign_id',
                                               description: 'Dodaj właściciela pojazdu' ,
                                               value:null,
                                               list:this.list.Client
                                             },
                                             ],
                                   }" >

        </FormAddComponent>
    </div>

    <div v-if="this.section==='orders'">
         <FormAddComponent
                          :modelName="this.modelName"
                          :form="{
                                    method:'create',
                                    inputs: [
                                              {
                                                name:'name',
                                                description:'Nazwa zamówienia',
                                                type:'text',
                                                value:'',
                                                placeholder:'Wpisz nazwę zamówienia'
                                              },
                                              {
                                                name:'price',
                                                description:'Cena zamówienia',
                                                type:'number',
                                                value:'',
                                                placeholder:'Cena'
                                              },
                                    ],
                                    selects: [],
                                    }"
                          ></FormAddComponent>
    </div>

    <div v-if="this.section==='employees'">
      <FormAddComponent
          :modelName="this.modelName"
          :form="{
                                    method:'create',
                                    inputs: [
                                              {
                                                name:'name',
                                                description:'Imię nazwisko pracownika',
                                                type:'text',
                                                value:'',
                                                placeholder:'Podaj imię i naz pracownika'
                                              },
                                    ],
                                    selects: [],
                                     }"
      ></FormAddComponent>
    </div>

    <div v-if="this.section==='clients'">
      <FormAddComponent
          :modelName="this.modelName"
          :form="{
                                    method:'create',
                                    inputs: [
                                              {
                                                name:'name',
                                                description:'Imię nazwisko pracownika',
                                                type:'text',
                                                value:'',
                                                placeholder:'Podaj imię i naz pracownika'
                                              },
                                    ],
                                     selects: [
                                             {
                                               name:'foreign_id',
                                               description: 'Przypisz pracownika' ,
                                               value:null,
                                               list:this.list.Employee
                                             },
                                             {
                                               name:'order_id',
                                               description: 'Zamów produkt' ,
                                               value:null,
                                               list:this.list.Order
                                             },
                                             {
                                               name:'car_id',
                                               description: 'Dodaj auto' ,
                                               value:null,
                                               list:this.list.Car
                                             },

                                    ], }"
      ></FormAddComponent>
    </div>

  </section>
</template>

<script>
import FormAddComponent from "@/components/aside/models-add/FormAddComponent.vue";
// import ClientAddComponent from "@/components/aside/models-add/ClientAddComponent.vue";
// import EmployeeAddComponent from "@/components/aside/models-add/EmployeeAddComponent.vue";
// import OrderAddComponent from "@/components/aside/models-add/OrderAddComponent.vue";
import {service} from "@/services/CrudService";
export default {
  name: "AddComponent",
  components:{
    FormAddComponent,
    // ClientAddComponent,
    // EmployeeAddComponent,
    // OrderAddComponent
  },
  props:{
    section:{
      type:String
    }
  },
  data(){
    return{
      modelName:null,
      list:[],
    }
  },
  mounted(){
    const keys = {clients:"Client", orders:"Order", employees:"Employee", cars:"Car"}
    this.modelName = keys[this.section]
    if (!Object.keys(keys).includes(this.section))
    {
      location.href="/"
    }
    for (let all of ['Client', 'Order', 'Car', 'Employee']) {
      service.read(all).then(res => {
        if (!res.error) {
          this.list[all] = res;
        }
      })
    }
  }
}
</script>

<style scoped>

</style>