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
            <router-link to="/TestEntry" class="nav-item nav-link">Home</router-link>
            <router-link to="/UserEntry" class="nav-item nav-link">Users</router-link>
            <a href="javascript:void(0)" style="margin-left:850px; margin-top:7px;text-decoration: none;" @click="handleClick">Logout</a>
        </div>

    </div>
</nav>
 </div>
  <router-view/> 
</div>
<div class="container offset-1 mt-5">
    <form @submit.prevent="userentry">
            <table class="col-md-8 table">
                <thead>
                    <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td><input class="form-control text-center " :required="true"  name="name" v-model="user.name"/></td>
                    <td><input class="form-control text-center" :required="true" name="email" type="email" v-model="user.email"/></td>
                    <td><input class="form-control text-center" :required="true" name="password" v-model="user.password"/></td>
                    <td>
                    <select class="form-control" :required="true" name="role" v-model="user.role">
                    <!-- <option  >Select User Role</option> -->
                    <option :selected="true" >Receptionist</option>
                    <option >Lab</option>
                    </select></td>
                    <td> <button type="submit" class="btn btn-warning text-center">
                    Create
                     </button> </td>
                    </tr>
                </tbody>
            </table>
    </form>
</div>
<div class="container offset-1 mt-5">
<b-row class="mb-3">
    <b-col md="3">
        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Search by Name"></b-form-input>
      </b-col>
</b-row>

    <b-row>
      <b-col md="12">
        <b-table
         ref="table"
          striped
          hover
          outlined
          id="my-table"
          :items="users"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
          @filtered="onFiltered"
        >
        <template #cell(name)="data">
          <div v-if="editting===data.item.id">
            <b-form-input type="text" name="name" v-model="form.name" ></b-form-input>
            </div>
          <span v-else>{{data.item.name}}</span>
        </template>
        <template #cell(email)="data">
          <div v-if="editting===data.item.id"><b-form-input type="text" name="email" v-model="form.email"></b-form-input></div>
          <span v-else>{{data.item.email}}</span>
        </template>
        <template #cell(password)="data">
          <div v-if="editting===data.item.id"><b-form-input type="text" name="password" v-model="form.password"></b-form-input></div>
          <span v-else>{{data.item.password}}</span>
        </template>
        <template #cell(role)="data">
          <div v-if="editting===data.item.id"><select class="form-control" :required="true" name="role" v-model="form.role">
                    <option :selected="true" >Select User Role</option>
                    <option >admin</option>
                    <option >Receptionist</option>
                    <option >Lab</option>
                    </select></div>
          <span v-else>{{data.item.role}}</span>
        </template>

          <template #cell(actions)="data">
            <div v-if="editting===data.item.id">
                <b-button @click="updateUser()" ><span ><i class="material-icons">&#xE86C;</i></span></b-button>
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="showDeleteModal=false; deleteUser(selectedRow.id)" >Confirm</button>
                </div>
                </div>
            </div>
            </div>
            </div>
          </template>
        </b-table>
 <div  class="text-center" v-if="users.length < 1"><p> No records available</p></div>
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
        user: {
            name: '',
            email: '',
            password:'',
            role:'',
        },
        users:[],
         filter: "",
      perPage: 5,
      currentPage: 1,
      fields: [
      { key: 'id', label: 'ID' },
      { key: 'name', label: 'Name', editable: true },
      { key: 'email', label: 'email', editable: true },
      { key: 'password', label: 'password', editable: true },
      { key: 'role', label: 'role', editable: true },
      "Actions"
    ],
      selectedRow: {},
      showDeleteModal: false,
      editting: null,
      form: {
          id: '',
          name: '',
          email: '',
          passoword:'',
          role:'',
        },
      form_index : 0,
      dynamic_class:true,
      message:'',
        }
     },

    computed: {
      rows() {
        return this.users.length
      },
    editableFields() {
      return this.fields.filter(field => field.editable)
    }
    },

    mounted() {
     this.getUsers();
    },

     methods:{
        userentry(e) {
                e.preventDefault()
                this.$http.post('http://127.0.0.1:8000/api/createUser', {
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password,
                    role: this.user.role,
                })
                .then((res)=>{
                    this.getUsers();
                    self.message = 'Data is entered'
                    })
                    this.user = {}
            },

        getUsers() {
        this.$http.get('http://127.0.0.1:8000/api/getUser')
         .then(response => {
             this.users = response.data.users
         })
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
        this.form.email = item.email
        this.form.password = item.password
        this.form.role = item.role
        this.form_index = index + ((this.currentPage - 1) * this.perPage)
      },

       deleteUser(id) {
                const index = this.users.indexOf(id);
                this.users.splice(index, 1);
                this.$http.delete("http://127.0.0.1:8000/api/deleteUser/" + id).then(()=> {
                //this.$router.push({ name: 'TestEntry' });
                //this.selectedRow = {};
                this.getUsers();
                 })
        },

        sendInfo(item) {
        this.selectedRow= item;
        },

        updateUser() {
            //alert(JSON.stringify(this.form))
             this.$http.post('http://127.0.0.1:8000/api/updateUser/' + this.form.id,this.form)
                .then((response)=>{
                    this.editting=null
                    this.getUsers();
                    //alert("update");
                    self.message = 'Data is entered';
                    })   
        },
        cancleButton()
        {
            this.form=''
            this.getUsers();

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