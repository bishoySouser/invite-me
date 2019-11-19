<template>
    <div id='users-page'>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{title}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active">{{title}}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                {{title}}
                </div>
            </div>
        </section>
        
        <nav class="navbar sticky-top" style="background: #f4f6f9;">
          
            <form class="form-inline ml-3 pr-2">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar rounded-pill" v-model="userSearch" type="search" placeholder="Search by email" aria-label="Search">
              </div>
            </form>
            
            <button class="btn btn-success float-right" style="flex-flow: row-reverse;" data-toggle="modal" data-target="#UserRegistration">
                User Registrations
            </button>
          
        </nav>

        <div class="users-list">
          <div class="row">

            <table class="table text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">User name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Type</th>
                  <th scope="col">Handling</th>
                </tr>
              </thead>
              <tbody>
                <!-- loading -->
                  <loading :active.sync="isLoading" 
                  :can-cancel="true" 
                  :on-cancel="onCancel"
                  :is-full-page="fullPage"></loading>

                <tr v-for='(user, index) in filteredList' :key="user.num">
                  <th scope="row">{{index+1}}</th>
                  <td>{{user.first_name+' '+user.last_name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.user_type}}</td>
                  <td>
                    <button class="btn btn-danger" data-toggle="modal" :data-target="'#model'+user.id">Delete</button>
                  </td>
                  <!-- Modal delete -->
                  <div class="modal fade" :id="'model'+user.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Delete "{{user.first_name+' '+user.last_name}}" ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                          <button type="button" class="btn btn-danger" @click="deleteUser(user.id)">Yes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </tr>
              </tbody>
            </table>
            
          </div>
        </div>

        <!-- User Registration Model -->
        <div class="modal fade" id="UserRegistration" tabindex="-1" role="dialog" aria-labelledby="UserRegistration" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">User Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  <!-- loading -->
                  <loading :active.sync="isLoading" 
                  :can-cancel="true" 
                  :on-cancel="onCancel"
                  :is-full-page="fullPage"></loading>
                  <form>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputFirstName">First name</label>
                        <input type="text" v-model="formRegister.first_name" class="form-control" id="inputFirstName" placeholder="First name">
                        <p class="text-danger pb-2" v-if="formRegister.first_name.length < 2">
                          first name is requried
                        </p>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputLastName">Last name</label>
                        <input type="text" v-model="formRegister.last_name" class="form-control"  id="inputLastName" placeholder="Last name">
                        <p class="text-danger pb-2" v-if="formRegister.last_name.length < 2">
                          last name is requried
                        </p>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-8">
                          <label for="inputEmail4">Email</label>
                          <input type="email" v-model="formRegister.email" class="form-control" id="inputEmail4" placeholder="Email">
                          <p class="text-danger pb-2" v-if="formRegister.email.indexOf('@') < 0">
                            email is requried or it isn't email
                          </p>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputUserIs">User is </label>
                        <select id="inputUserIs" class="form-control" v-model="formRegister.user_type">
                          <option>Company</option>
                          <option>Exhibitor</option>
                          <option>Innovator</option>
                        </select>
                      </div>
                    </div>

                    
                    
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="addUser" :disabled="(formRegister.first_name.length && formRegister.last_name.length) < 2 || formRegister.email.indexOf('@') < 0">Add user</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    name:"UsersPage",
    components: {
            Loading
        },
    data() {
        return{
            title: 'Users',
            formRegister: new Form({
                first_name: '',
                last_name: '',
                email: '',
                user_type: 'Innovator',
            }),
            users:[],
            userSearch:'',
            //loading
            isLoading: false,
            fullPage: true
        }
    },
    computed: {
        filteredList() {
            return this.users.filter(user => {
                return user.email.toLowerCase().includes(this.userSearch.toLowerCase())
            })
        }
    },
    methods:{
      getUsersList(){
        axios.get('v1/admin/usersList',this.isLoading = true)
        .then((res) => {
          // simulate AJAX
                setTimeout(() => {
                 this.isLoading = false
                },300)
          this.users = res.data.list
          console.log(res.data.list);
        })
      },
      addUser(){
        this.formRegister.post('v1/meeting/admin/userAdd',this.isLoading = true)
        .then((res) => {
                // simulate AJAX
                setTimeout(() => {
                 this.isLoading = false
                },300)
          if(res.status == 202){
            this.formRegister.reset();
            toast.fire({
              type: 'error',
              title: 'Error!',
              text: 'User is already registered',
              confirmButtonText: 'Cool'
            })
          }else{
            $('#UserRegistration').modal('hide')
            this.formRegister.reset();
            toast.fire({
              type: 'success',
              title: res.data.msg
            })
            location.reload();
            // console.log(res);
          }
          
        })
        
      },
      deleteUser(id){
        console.log(id)
        axios.delete('v1/admin/user/' + id)
            .then((res) => {
                $('#model'+id).modal('hide')
                location.reload();
            })
      },
      onCancel() { //loading pluging
              console.log('User cancelled the loader.')
            }
    },
    created(){
      this.getUsersList()
      document.title = this.title
    }
    
      
  
}
</script>

<style lang="sass" scoped>

</style>