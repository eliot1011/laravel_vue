<template>
<div>
  <div id="nav">
  <nav class="container navbar navbar-expand-lg navbar-light bg-light">
    <!-- <a class="navbar-brand" href="#">Diagnostic Center</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav mr-auto">
            <router-link to="/PatientListLab" class="nav-link">Home</router-link>
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
<br>
<br>
 <div class="container offset-1">
  <span>ID: {{patientInfo.patient_id}}</span>
  <br>
  <span>Name: {{patientInfo.name}}</span>
  <br>
  <span>Email:{{patientInfo.email}}</span>
  <br><br>
  <form @submit.prevent="resultEntry">
 <table id="example" class="table table-striped text-center" style=" background-color: rgb(0, 225, 255);">
    <thead> 
            <th>Test ID</th>
            <th>Test Name</th>
            <th>Result</th>
            <th>Condition</th>
            <th>Expected</th>

    </thead>
<tbody>  
  <tr v-for="(list,i) in patient" :key="i">
    <td>{{list.test_id}}</td>
    <td>{{list.test_name}}</td>
    <td>
      <!-- <input type="text" v-model="result[i]" /> -->
     <select :required="true"  v-model="result[i]">
      <option >Low</option>
      <option >Normal</option>
      <option >High</option>
     </select>
    </td>
    <td>1.00 - 5.00</td>
    <td>Normal</td>
  </tr>
</tbody>
</table>

 <b-button type="submit" @click="click()" variant="success">Submit</b-button>
 </form>
 </div>
 <br>
<br>
<div class="col-sm-2 col-md-8 offset-md-2 " style="margin-top:160px">
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
       result: [],
       show:false
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

        detailsPage(){
        this.$router.push({name:'ResultEntry'})
         },

         resultEntry(){
            this.$http.post('http://127.0.0.1:8000/api/resultEntry', {
                    patient_id: this.patientInfo.patient_id,
                    test: this.patient,
                    result: this.result,
                })
                .then((res)=>{
                    self.message = 'Data is entered'
                    
                     this.$router.push({ name: 'PatientListLab' });
                    })
         },

        click() {
       this.$http.post('http://127.0.0.1:8000/api/send/'+this.patientInfo.email, {
            //body: JSON.stringify(this.patient.email),
        })
        .then(res => res.json())
        .then(data => {
            console.log("email sent");
        })
        .catch(err => console.error(err.toString()));
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
/* #nav {
  padding: 30px;
  text-align: center;
}

#nav a {
  font-weight: bold;
  color: #2c3e;
}

#nav a.router-link-exact-active {
  color: rgb(58, 203, 223);
  background: crimson;
  border-radius: .5rem;
} */
body {background:  #00C9FF;
  
  /* background: linear-gradient(to right, #72eff3ee, #008c91); */
}
</style>