<template>
<div class="container">
    <div id="nav" class="row">
  <nav class="container navbar navbar-expand-lg navbar-light bg-light">
    <!-- <a class="navbar-brand" href="#">Diagnostic Center</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav mr-auto">
            <router-link to="/PatientEntry" class="nav-item nav-link">Home</router-link>
            <router-link to="/PatientList" class="nav-link">List</router-link>
            <a href="javascript:void(0)" style="margin-left:850px; margin-top:7px;text-decoration: none;" @click="handleClick">Logout</a>
        </div>
        <!-- <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form> -->
    </div>
</nav>
 </div>
  <router-view/> 
<div class="row">
<div class="col-6 mt-5">
  <form @submit.prevent="patientEntry">
     <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" v-model="patients.name"  placeholder="Enter Name" required>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" v-model="patients.email" placeholder="Enter email" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Age</label>
    <input type="number" class="form-control" v-model="patients.age" placeholder="Enter Age" required>
  </div>
 
<div class="form-check-inline">
    <div class="form-group">
          <label>Gender</label>
      <br>
            <input class="form-check-input" type="radio" v-model="patients.gender"  id="" value="Male" >
                <label class="form-check-label" for="">
                    Male
            </label>
            <input class="form-check-input" type="radio" v-model="patients.gender" id=""  value="Female" >
                <label class="form-check-label" for="">
                    Female
            </label>
    </div>
</div>
<div class="form-group">
    <label for="exampleInputPassword1">Phone Number</label>
    <input type="number" class="form-control" v-model="patients.phone" placeholder="Enter Phone Number" required>
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
    <tr v-for="(test,index) in selected" :key="index"> 
      <td>{{test.id}}</td>
      <td>{{test.name}}</td>
      <td>{{test.price}}</td>
      <td><b-button @click="cancleButton(index)" > <span><i class="material-icons">&#xE5CD;</i></span></b-button></td>
    </tr> 
  </tbody>
   <div  class="text-center" v-if="selected.length < 1"><p>No Test selected yet!</p></div>
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
 <b-button type="submit" @click="download" onclick="window.print()" variant="success">Submit</b-button>

  <!-- <router-link to="/pdfview/ + {iddd}" class="btn btn-sm btn btn-warning"> View</router-link> -->
    

</form>
</div>

<div class="col-6 mt-5">
<b-row class="mb-3">
    <b-col md="5">
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
          class="table table-striped text-center"
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
        <input type="checkbox" v-model="selected" :value="data.item" @click="selectSingleRow"/>
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
<br>
<br>
<div class="col-sm-2 col-md-8 offset-md-2 ">
<div style="color:skyblue; border-top: 2px solid;"></div>
</div>
<footer class="text-center">
      <pre>
        <code>
          Copyright ©2011-2021 Chittagong Diagnostic Center, All Rights Reserved.
          <!-- Software Section , Department of IT,Premier University (Design & Develop) -->
        </code>
      </pre>
</footer>
</div>
</template>

<script>
import _ from 'lodash';
import jsPDF from 'jspdf';
//import VueHtmlToPaper from 'vue-html-to-paper';
//import html2canvas from "html2canvas"
export default {
    data(){
        return{
        discount: 0,
        advance: 0,
        selected:[],
        patients: {
            name: '',
            email: '',
            age: '',
            gender: '',
            phone: '',
            // selected:[],
            //line_total: 0
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
      patientRecept: [],
      patientInfo: {},
      
        }
    },
    computed: {
      rows() {
        return this.columns.length
      },
       total_price() {
      return _.reduce(this.selected, function(memo, product) {
        return memo + product.price;
      }, 0);
    },
        discountedPrice() {
    return this.total_price - (this.total_price *(this.discount)/100)
  },
        iddd() {
    return this.patient.patient_id
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

        getPatients() {
        this.$http.get('http://127.0.0.1:8000/api/getPatient')
         .then(response => {
             this.patientRecept = response.data.patient
         })
        },

        latestPatient(){
          this.$http.get('http://127.0.0.1:8000/api/latestPatient/'+this.patientInfo.patient_id)
         .then(response => {
             this.patientInfo = response.data
         })
      },

        selectSingleRow(){
            
        },

        patientEntry(e){
          e.preventDefault()
                this.$http.post('http://127.0.0.1:8000/api/PatientEntry', {
                    name: this.patients.name,
                    email: this.patients.email,
                    age: this.patients.age,
                    gender: this.patients.gender,
                    phone: this.patients.phone,

                    total_price: this.discountedPrice,
                    advance: this.advance,
                    due:this.discountedPrice - this.advance,
                    selected: this.selected,

                })
                .then((res)=>{
                    //this.getTests();
                    self.message = 'Data is entered'
                    })
                    this.patients = {}
                    this.selected = []
                    this.advance = 0
                    //this.$router.push("/PrintRecept");

                    //this.$router.push({ name: 'LatestPatient' });

        },
        
        cancleButton(index)
        {
            this.selected.splice(index, 1)
            this.discount=0,
            this.advance=0
        },

        download(){
            // var doc = new jspdf();
            // doc.text=(this.patients.name,this.patients.email,this.patients.age,this.patients.gender,this.patients.phone,15,15);      
            // doc.save('test.pdf');

            // const doc = new jsPDF();
            // const contentHtml = this.$refs.content.innerHTML;
            // doc.fromHTML(contentHtml, 15, 15, {
            // width: 170
            // });
            // doc.save("recept.pdf");
             
        },
        handleClick()
        {
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        this.$router.push('/Login');
        },



  }
}

</script>

<style>
body {background:  #00C9FF;}
</style>
