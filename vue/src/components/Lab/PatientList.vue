<template>
<div class="container">
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
            <router-link to="/PatinetListLab" class="nav-item nav-link">Home</router-link>
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
<div class="container offset-2 mt-5">
<b-row class="mb-3">
    <b-col md="3">
        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Search by Name"></b-form-input>
      </b-col>
</b-row>

    <b-row>
      <b-col md="8">
        <b-table
         ref="table"
          striped
          hover
          outlined
          id="my-table"
          :items="patients"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
          @filtered="onFiltered"
        >
        <template #cell(name)="data">
          <span >{{data.item.name}}</span>
        </template>
        <template #cell(patient_id)="data">
          <span>{{data.item.patient_id}}</span>
        </template>
        <template  #cell(actions)="data">
         <router-link  v-bind:to="'/ResultEntry/' + data.item.patient_id" class="btn btn-sm btn btn-warning" style="width: 120px;"> Add Result</router-link>
        </template>
        </b-table>
 <div  class="text-center" v-if="patients.length < 1"><p> No Patients available</p></div>
        <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          first-text="⏮"
          prev-text="⏪"
          next-text="⏩"
          last-text="⏭"
          aria-controls="my-table"
        ></b-pagination>
      </b-col>
</b-row>
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
        filter: "",
        perPage: 5,
        currentPage: 1,
        fields: [
      { key: 'patient_id', label: 'ID' },
      { key: 'name', label: 'Name'},
      { key: 'due', label: 'Due' },
      "Actions"
      ],
        patients:[],
        }
    },

    computed: {
      rows() {
        return this.patients.length
      }
    },

    mounted() {
     this.getPatients();
    },
    methods:{

        onFiltered(filteredItems) {
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },

        detailsPage(){
            this.$router.push({name:'ResultEntry'})
         },

        getPatients() {
        this.$http.get('http://127.0.0.1:8000/api/getPatientreportstatus')
         .then(response => {
             this.patients = response.data.patient
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

<style>
body {background:  #00C9FF;
  
  /* background: linear-gradient(to right, #72eff3ee, #008c91); */
}
.navclr{
  background: #92FE9D;
  /* border-radius: 25px; */
}


</style>