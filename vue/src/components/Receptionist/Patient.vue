<template>
<div>
<div class="row">
<div class="col-6 mt-5">
    <form @submit.prevent="patientEntry">
     <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" v-model="patients.name" aria-describedby="name" placeholder="Enter Name">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" v-model="patients.email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Age</label>
    <input type="number" class="form-control" v-model="patients.age" placeholder="Enter Age">
  </div>
 
<div class="form-check-inline">
    <div class="form-group">
            <input class="form-check-input" type="radio" v-model="patients.gender" name="gender" id="" value="Male">
                <label class="form-check-label" for="">
                    Male
            </label>
            <input class="form-check-input" type="radio" v-model="patients.gender" name="gender" id=""  value="Female">
                <label class="form-check-label" for="">
                    Female
            </label>
    </div>
</div>
<div class="form-group">
    <label for="exampleInputPassword1">Phone Number</label>
    <input type="number" class="form-control" v-model="patients.phone" placeholder="Enter Phone Number">
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="test in patients.selected" :key="test.id"> 
      <td>{{test.id}}</td>
      <td>{{test.name}}</td>
      <td>{{test.price}}</td>
      <td><b-button @click="cancleButton(test)"> <span><i class="material-icons">&#xE5CD;</i></span></b-button></td>
    </tr> 
  </tbody>
   <div  class="text-center" v-if="patients.selected.length < 1"><p> No Test selected yet!</p></div>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">Sub Total</td>
            <td  class="text-right">{{total_price}}</td>
        </tr>
         <tr>
            <td colspan="5" class="text-right">Discount (%)</td>
            <input class="form-control text-right" type="number" v-model="discount"/>
        </tr>
         <tr>
            <td colspan="5" class="text-right">Total</td>
            <td  class="text-right">{{discountedPrice}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Advance</td>
             <input class="form-control text-right" type="number" v-model="advance"/>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Due</td>
            <td  class="text-right">{{discountedPrice-advance}}</td>
        </tr>

    </tfoot>
</table>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<div class="col-6 mt-5">
<b-row class="mb-3">
    <b-col md="3">
        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Search by Name"></b-form-input>
      </b-col>
</b-row>

    <b-row >
<b-table
         ref="table"
          striped
          hover
          outlined
          id="my-table"
          :items="columns"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
          @filtered="onFiltered"
        >
         <template #cell(id)="data">
          <span>{{data.item.id}}</span>
        </template>
        <template #cell(name)="data">
          <span>{{data.item.name}}</span>
        </template>
        <template #cell(price)="data">
          <span>{{data.item.price}}</span>
        </template>
        <template v-slot:cell(actions)="data">
         <b-form-group>
        <input type="checkbox" v-model="patients.selected" :value="data.item" @click="selectSingleRow"/>
         </b-form-group>
        </template>
        </b-table>
        
        <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          first-text="⏮"
          prev-text="⏪"
          next-text="⏩"
          last-text="⏭"
          aria-controls="itemList"
        ></b-pagination>

</b-row>
</div>
</div>
</div>
</template>
<script>
import _ from 'lodash';
export default {
    data(){
        return{
        invoice_subtotal: 0,
        invoice_total: 0,
        discount: 0,
        advance: 0,
        patients: {
            name: '',
            email: '',
            age: '',
            gender: '',
            phone: '',
            selected:[],
            line_total: 0
        },

      filter: "",
      perPage: 5,
      currentPage: 1,
      fields: [ "id", "name", "price", "Actions"],
      columns:[],
      selectedRow: {},
      showDeleteModal: false,
      editting: null,
      allselected: false,

        }
    },
    computed: {
      rows() {
        return this.columns.length
      },
       total_price() {
      return _.reduce(this.patients.selected, function(memo, product) {
        return memo + product.price;
      }, 0);
    },
            discountedPrice() {
    return this.total_price - (this.total_price *(this.discount)/100)
  },
    },


    mounted() {
     this.getTests();
    },

    
    methods: {
        saveInvoice() {
            console.log(JSON.stringify(this.invoice_products));
        },
        sendInfo(item) {
        this.selectedRow= item;
    },

        onFiltered(filteredItems) {
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },

        getTests() {
        this.$http.get('http://127.0.0.1:8000/api/getTest')
         .then(response => {
             this.columns = response.data.columns
         })
        },

        selectSingleRow(){
            
        },

        patientEntry(){

        },
        
        cancleButton(test)
        {
            this.patients.selected.splice(test, 1)
            this.discount=0,
            this.advance=0
        },

  }
}

</script>

<style>

</style>
