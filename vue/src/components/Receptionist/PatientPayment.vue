<template>
<div>
    <div id="app" class=" container" v-bind:style="{ backgroundColor: color}">
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
</div>
<br>
<br>

 <div class="container offset-1">
  <span>ID: {{patientInfo.patient_id}}</span>
  <br>
  <span>Name: {{patientInfo.name}}</span>
  <br>
  <span>Email:{{patientInfo.email}}</span>
 <table id="example" class="table table-striped text-center" style=" background-color: rgb(0, 225, 255);">
    <thead> 
      <th>Test</th>
      <th>Cost</th>
    </thead>
<tbody> 
  <tr v-for="(list,i) in patient" :key="i">
    <td>{{list.test_name}}</td>
      <td>{{list.price}}</td>
  </tr>
</tbody>
 </table>


<form @submit.prevent="updatePatientPayment">
 <table class="table">
  <tbody>
  </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">Total</td>
            <td  class="text-right">{{patientInfo.total}}</td>
        </tr>
         <tr>
            <td colspan="5" class="text-right">Advance Paid</td>
            <td  class="text-right">{{patientInfo.advance}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Due</td>
            <td  class="text-right" >{{patientInfo.due}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Pay</td>
            <input class="form-control text-right" type="number" v-model="form.pay"/>
        </tr>
        <tr>
            <td colspan="5" class="text-right">New Due</td>
            
            <td  class="text-right">{{patientInfo.due-form.pay}}</td>
        </tr>
    </tfoot>
</table>
 <b-button type="submit" variant="success">Submit</b-button>
</form>
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
export default {
    data(){
        return{
        id:this.$route.params.id,
        filter: "",
        perPage: 5,
        currentPage: 1,
        fields: [
      { key: 'patient_id', label: 'ID' },
      { key: 'name', label: 'Name'},
      { key: 'due', label: 'Due' },
      "Actions"
      ],
       patient:[],
       patientInfo:{},
       form:{
        pay:0,
        //due:0,
       },
       due:0
        }
    },

    computed: {
      rows() {
        return this.patients.length
      }
    },

    created() {
      //patients er test gula array tah nissi
        this.$http.get('http://127.0.0.1:8000/api/patientDetails/' + this.id)
         .then(response => {
             this.patient = response.data.patient
         })
      //patient er details
        this.$http.get('http://127.0.0.1:8000/api/patientInfo/'+this.id)
         .then(response => {
             this.patientInfo = response.data
         }) 
    },

    methods:{
        onFiltered(filteredItems) {
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },

      getSingleData(){
        this.$http.get('http://127.0.0.1:8000/api/patientInfo/'+this.id)
         .then(response => {
             this.patientInfo = response.data
         })
      },

        updatePatientPayment() {
          this.$http.post('http://127.0.0.1:8000/api/updatePatientPayment/' + this.id,this.form)
                .then(()=>{
                  this.getSingleData(),
                  this.form.pay=0,
                    self.message = 'Data is entered';
                    })   
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

<style scoped>
body {background:  #00C9FF;}
</style>