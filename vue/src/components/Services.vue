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
            <router-link to="/" class="nav-item nav-link">Home</router-link>
            <router-link to="/Services" class="nav-item nav-link">Services</router-link>

            <a href="/PatientLogin" style="margin-left:900px; margin-top:7px;text-decoration: none;">Login</a>
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
 <div class="container offset-1">
<br>
<b-row class="mb-3">
    <b-col md="3">
        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Search by Name"></b-form-input>
      </b-col>
</b-row>

    <b-row>
      <b-col md="10">
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
        <template #cell(name)="data">
          <div v-if="editting===data.item.id">
            <b-form-input type="text" name="name" v-model="form.name" required></b-form-input>
            </div>
          <span v-else>{{data.item.name}}</span>
        </template>
        <template #cell(price)="data">
          <div v-if="editting===data.item.id"><b-form-input type="number" name="price" v-model="form.price"></b-form-input></div>
          <span v-else>{{data.item.price}}</span>
        </template>

        </b-table>
 <div  class="text-center" v-if="columns.length < 1"><p> No records available</p></div>
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
 </div>

</template>


<script>
export default {
    computed: {
    editableFields() {
      return this.fields.filter(field => field.editable)
    }
  },
    data(){
        return{
        invoice_products: [{
            name: '',
            price: '',
        }],

  dynamic_class:true,
  message:'',
  password:'',
  is_disable:false,
  class_name:'',

      filter: "",
      perPage: 10,
      currentPage: 1,
      fields: [
      { key: 'id', label: 'ID' },
      { key: 'name', label: 'Name', editable: true },
      { key: 'price', label: 'Price', editable: true },
    ],
      columns:[],
      selectedRow: {},
      showDeleteModal: false,
      editting: null,
      form: {
          id: '',
          name: '',
          price: '',
        },
      form_index : 0,
      dynamic_class:true,
      message:'',
        }
    },

    validations: {
      invoice_products:[{
        name:'',
      }]
    },

    computed: {
      rows() {
        return this.columns.length
      }
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

        handleEditRow(data) {
        this.selectedRow = {
          [data.index]: !this.selectedRow[data.index],
        }
      },

      editMode(id,item,index){
        this.editting = id; 
        this.form.id = item.id
        this.form.name = item.name
        this.form.price = item.price
        this.form_index = index + ((this.currentPage - 1) * this.perPage)
      },

        test(e) {
                e.preventDefault()
                this.$http.post('http://127.0.0.1:8000/api/createTest', {
                    invoice_products: this.invoice_products
                })
                .then((res)=>{
                    this.getTests();
                    self.message = 'Data is entered'
                    })
                    this.invoice_products = []
                    this.addNewRow()
                    //this.$router.push({ name: 'TestEntry' });
            },


        deleteRow(index, invoice_product) {
            var idx = this.invoice_products.indexOf(invoice_product);
            console.log(idx, index);
            if (idx > -1) {
                this.invoice_products.splice(idx, 1);
            }
        },

        addNewRow() {
            this.invoice_products.unshift({
                name: '',
                price: '',
            });
        },

        getTests() {
        this.$http.get('http://127.0.0.1:8000/api/getTest')
         .then(response => {
             this.columns = response.data.columns
         })
        },

        deleteTest(id) {
                const index = this.columns.indexOf(id);
                this.columns.splice(index, 1);
                this.$http.delete("http://127.0.0.1:8000/api/deleteTest/" + id).then(()=> {
                //this.$router.push({ name: 'TestEntry' });
                //this.selectedRow = {};
                this.getTests();
                 })
        },

        updateTest() {
            //alert(JSON.stringify(this.form))
             this.$http.post('http://127.0.0.1:8000/api/updateTest/' + this.form.id,this.form)
                .then((response)=>{
                    this.editting=null
                    this.getTests();
                    //alert("update");
                    self.message = 'Data is entered';
                    })   
        },
        cancleButton()
        {
            this.form=''
            this.getTests();

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

.success
{
 font-weight: bold;
 color:#009933;
 background-color: #ccffcc;
 border:1px solid #009933;
}

.danger
{
 font-weight: bold;
 color:#ff0000;
 background-color: #ffe6e6;
 border:1px solid #ff0000;
}
body {background:  #00C9FF;}
</style>