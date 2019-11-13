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
        
        <div class="content">
          <div class="row my-2">
            <form class="form-inline ml-3 pr-2 mx-auto">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar rounded-pill" type="search" placeholder="Search users" aria-label="Search">
              </div>
            </form>
            
            <button class="btn btn-success" data-toggle="modal" data-target="#UserRegistration">
                User Registrations
            </button>
          </div>
        </div>
        <div class="users-list">
          <div class="row">

            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">User name</th>
                  <th scope="col">Email</th>
                  <th scope="col">User type</th>
                  <th scope="col">Meeting</th>
                  <th scope="col">Handling</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
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
                  <form>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputFirstName">First name</label>
                        <input type="text" v-model="formRegister.firstName" class="form-control" id="inputFirstName" placeholder="First name">
                        <p class="text-danger pb-2" v-if="formRegister.firstName.length < 2">
                          first name is requried
                        </p>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputLastName">Last name</label>
                        <input type="text" v-model="formRegister.lastName" class="form-control"  id="inputLastName" placeholder="Last name">
                        <p class="text-danger pb-2" v-if="formRegister.lastName.length < 2">
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
                        <select id="inputUserIs" class="form-control" v-model="formRegister.userType">
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
                <button type="button" class="btn btn-primary" @click="addUser" :disabled="(formRegister.firstName.length && formRegister.lastName.length) < 2 || formRegister.email.indexOf('@') < 0">Add user</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"UsersPage",
    data() {
        return{
            title: 'Users',
            formRegister: {
                firstName: '',
                lastName: '',
                email: '',
                userType: 'Innovator',
            }, 
        }
    },
    methods:{
      addUser(){
        axios.post('v1/meeting/admin/userAdd', {
            first_name: this.formRegister.firstName,
            last_name: this.formRegister.lastName,
            email: this.formRegister.email,
            user_type: this.formRegister.userType,
        })
        .then((res) => {
          if(res.data.msg = 'User is already registered'){
            alert('User is already registered')
            this.formRegister.email = ''
          }else{
            alert('User add');
            formRegister.reset()
          }
        })
      }
    },
    
      
  
}
</script>

<style lang="sass" scoped>

</style>