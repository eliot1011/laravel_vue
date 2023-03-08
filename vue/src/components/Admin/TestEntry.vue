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
            <router-link to="/TestEntry" class="nav-item nav-link">Home</router-link>
            <router-link to="/UserEntry" class="nav-link">Users</router-link>
            <a href="javascript:void(0)" style="margin-left:850px; margin-top:7px;text-decoration: none;" @click="handleClick">Logout</a>
        </div>
    </div>
</nav>
 </div>
  <router-view/> 
</div>

 <div class="container offset-1">
   <br>
      <button type='button' class="btn btn-info" @click="addNewRow">
    <i class="fas fa-plus-circle"></i>
    Add
    </button>
<br>
<form ref="anyName" @submit.prevent="test">
<tr v-for="(invoice_product, k) in invoice_products" :key="k"> 
    <td scope="row" class="trashIconContainer">
        <i class="far fa-trash-alt" @click="deleteRow(k, invoice_product)"></i>
    </td>

    <td>
        <input class="form-control" required type="text"  placeholder="Enter Test Name" v-model="invoice_product.name"/>
    </td>

    <td>
        <input class="form-control text-right" required type="number" placeholder="Enter Price" min="0" step=".01" v-model="invoice_product.price"/>
    </td>
</tr>
<div>
  <b-button type="submit" variant="success">Submit</b-button>
</div>
</form>
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

          <template #cell(actions)="data">
            <div v-if="editting===data.item.id">
                <b-button @click="updateTest()" ><span ><i class="material-icons">&#xE86C;</i></span></b-button>
                <b-button @click="editting = null;cancleButton"><span ><i class="material-icons">&#xE5CD;</i></span></b-button>
            </div>

            <div v-else>
            <button  class="edit" title="Edit" data-toggle="tooltip"   @click="editMode(data.item.id,data.item,data.item.index)"> <span ><i class="material-icons">&#xE254;</i></span></button>
            <button class="delete" title="Delete" data-toggle="modal" data-target="#exampleModalCenter" @click="showDeleteModal=true; sendInfo(data.item)" ><i class="material-icons">&#xE872;</i></button>

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  v-if="showDeleteModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Confirmation!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="showDeleteModal=false">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>"{{selectedRow.name}}" ?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="showDeleteModal=false">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="showDeleteModal=false; deleteTest(selectedRow.id)" >Confirm</button>
                </div>
                </div>
            </div>
            </div>
            </div>
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
      perPage: 5,
      currentPage: 1,
      fields: [
      { key: 'id', label: 'ID' },
      { key: 'name', label: 'Name', editable: true },
      { key: 'price', label: 'Price', editable: true },
      "Actions"
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
             this.$http.put('http://127.0.0.1:8000/api/updateTest/' + this.form.id,this.form)
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