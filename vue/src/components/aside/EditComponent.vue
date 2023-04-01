<template>
<section>
  <h1>{{translatable[model] }}</h1>
      <div v-if="this.model === 'Client'">
        <FormEditComponent
            :modelName="this.model"
            :id="this.id"
            :form="{
                                    method:'create',
                                    inputs: [
                                              {
                                                name:'name',
                                                description:'Imię nazwisko pracownika',
                                                type:'text',
                                                value:this.editableModel.name,
                                                placeholder:'Podaj imię i naz pracownika'
                                              },
                                    ],
                                     selects: [
                                             {
                                               name:'foreign_id',
                                               description: 'Przypisz pracownika' ,
                                               value:this.editableModel.employee_id,
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
        ></FormEditComponent>

      </div>
      <div v-if="this.model === 'Car'">
        <FormEditComponent
            :modelName="this.model"
            :id="this.id"
            :form="{
                                                method:'create',
                                                inputs: [
                                                          {
                                                            name:'name',
                                                            description:'Marka i nazwa auta',
                                                            type:'text',
                                                            value:this.editableModel.name,
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

                                                data: this.editableModel.clients
                                   }" >

        </FormEditComponent>
      </div>
      <div v-if="this.model === 'Order'">
        <FormEditComponent
            :id="this.id"
            :modelName="this.model"
            :form="{
                                    method:'create',
                                    inputs: [
                                              {
                                                name:'name',
                                                description:'Nazwa zamówienia',
                                                type:'text',
                                                value:this.editableModel.name,
                                                placeholder:'Wpisz nazwę zamówienia'
                                              },
                                              {
                                                name:'price',
                                                description:'Cena zamówienia',
                                                type:'number',
                                                value:this.editableModel.price,
                                                placeholder:'Cena'
                                              },
                                    ],
                                    selects: [],
                                    }"
        ></FormEditComponent>
      </div>
      <div v-if="this.model === 'Employee'">
        <FormEditComponent
            :modelName="this.model"
            :id="this.id"
            :form="{
                                    method:'create',
                                    inputs: [
                                              {
                                                name:'name',
                                                description:'Imię nazwisko pracownika',
                                                type:'text',
                                                value:this.editableModel.name,
                                                placeholder:'Podaj imię i naz pracownika'
                                              },
                                    ],
                                    selects: [],
                                     }"
        ></FormEditComponent>
      </div>
</section>

</template>

<script>
import {service} from "@/services/CrudService";
import FormEditComponent from "@/components/aside/form-edit/FormEditComponent.vue";
export default {
  name: "EditComponent",
  components:{
    FormEditComponent
  },
  data(){
    return{
      list:[],
      translatable: {Client:"Klient", Car:"Auto", Order:"Zamówienie", Employee:"Pracownik"},
      editableModel:{},
    }
  },
  mounted() {
        for (let all of ['Client', 'Order', 'Car', 'Employee']) {
        service.read(all).then(res => {
          if (!res.error) {
            this.list[all] = res;
          }
        })
      }
      service.read(this.model, this.id).then(editable =>{
        this.editableModel = editable;
      })
  },
  props:{
    id:{
      type:String,
      required: true
    },
    model:{
      type:String,
      required:true
    },
  },
}
</script>

<style >
section{
  font-family: PoppinsRegular, sans-serif;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  padding: 20px;
}
.save{
  display:block;
  background: none;
  border:solid 2px orange;
  border-radius: 12px;
  padding:12px;
  margin-block: 15px;
  color:orange;
  font-family: PoppinsMedium, sans-serif;
  padding-inline: 30px;
  transition: background-color 0.6s ease, color 0.6s ease;
}
.save:hover{
  background-color: orange;
  color:white;
  cursor:pointer
}
input, select{
  padding: 3px;
  border-radius:10px;
  padding-inline: 10px;
  border: solid 1px orange;
  font-style: italic;
  background: white;
}
</style>