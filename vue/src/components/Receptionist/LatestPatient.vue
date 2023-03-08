<template>
<div>
<div id="appp" ref="testHtml">
{{patients.patient_id}}
</div>  
<button  id="btnPrint">pdf</button>
</div>  
</template>

<script>
import html2canvas from "html2canvas";
import jsPDF from "jspdf";

export default {
    data(){
        return{
        id:this.$route.params.id,
        patients:{},
        }
    },


    mounted(){
     this.getPatients();
    },

    methods:{


    
        getPatients() {
        this.$http.get('http://127.0.0.1:8000/api/latestPatient/'+this.id)
         .then(response => {
             this.patients = response.data
         })
        },
    }
    
}
</script>

<style>


</style>