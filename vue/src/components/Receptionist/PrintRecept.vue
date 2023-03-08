<template>
<div id="app" ref="testHtml">

  {{patientInfo.patient_id}}
  {{patientInfo.name}}
  {{patientInfo.age}}
 <table id="example" class="table table-striped text-center" style=" background-color: rgb(0, 225, 255);">
    <thead> 
            <th>Test</th>
            <th>Result</th>
            <th>Condition</th>
            <th>Expected</th>

    </thead>
<tbody>  
  <tr v-for="(list,i) in patient" :key="i">
    <td>{{list.test_name}}</td>
    <td><input type="text" placeholder="" /></td>
    <td>{{list.test_name}}</td>
    <td>{{list.test_name}}</td>
  </tr>
</tbody>
</table>
 <b-button type="submit"  @click="generatePdf" variant="success">Submit</b-button>
</div>
</template>

<script>
import jsPDF from "jspdf";
export default {
    data(){
        return{
        //id:this.$route.params.id,
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
        }
    },

    computed: {
      rows() {
        return this.patients.length
      }
    },

    created() {
      //patients er test gula array tah nissi
        this.$http.get('http://127.0.0.1:8000/api/latestPatient/' + this.patientInfo.patient_id)
         .then(response => {
             this.patient = response.data.patient
         })
      //patient er details
        this.$http.get('http://127.0.0.1:8000/api/latestPatient/'+this.patientInfo.patient_id)
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

          generatePdf(){
       var doc = new jsPDF('p', 'pt', 'A4');
       doc.text=(this.patientInfo.name,this.patientInfo.email,this.patientInfo.age,this.patientInfo.gender,this.patientInfo.phone,15,15);      

      
      doc.save('test.pdf');
    }
    }
    
}
</script>

<style scoped>

</style>