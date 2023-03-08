<template>
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
            <router-link to="/" class="nav-item nav-link">Home</router-link>
            <router-link to="/Services" class="nav-item nav-link">Services</router-link>
            <router-link to="/PatientReport" class="nav-item nav-link">Report</router-link>
            <a href="javascript:void(0)" style="margin-left:850px; margin-top:7px;text-decoration: none;" @click="handleClick">Logout</a>
        </div>
    </div>

 </nav>
</div>
<router-view/> 

<h1><strong>Welcome!</strong></h1>

<br>
<br>
<div class="col-sm-2 col-md-8 offset-md-2 " style="margin-top:170px">
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
            result:[],
        }
    },   
           async created() {
            const token = localStorage.getItem('token');
            const baseURI = 'http://127.0.0.1:8000/api/reportResult/' + token;
            const response = await this.$http.get(baseURI, {
                //session_id: this.session
            });
            this.result = response.data.result;
            console.log(response.data);
        },

     methods: {
        handleClick() {
            localStorage.removeItem('token');
            localStorage.removeItem('patient_id');
            this.$router.push({ name: 'Login' });
        },
     }
    
}
</script>
<style>
body {
  
  background:  #00C9FF;
  /* background-image: url("/static/docc.webp"); */
}

h1 {text-align: center;
margin-top: 150px;}
</style>