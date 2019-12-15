<template>
   <div id='admin-slidbar'>
          <li class="nav-item has-treeview menu-open">  
              <router-link to="/admin" class="nav-link" @click="activeTab = '1'" activeClass="nav-link active" exact>
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </router-link>
          </li>
         <li class="nav-item has-treeview">
            <a href="#" class="nav-link" @click="activeTab = '2'">
              <i class="fas fa-grip-horizontal"></i>
              <p>
                Category
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <router-link tag="li" to="/admin/users" class="nav-item" >
                <a href="#" class="nav-link ml-3" @click="activeTab = '2'" activeClass="nav-item active">
                <i class="far fa-circle"></i>
                  <p>User</p>
                </a>
              </router-link>
              <router-link tag="li" to="/admin/meeting" class="nav-item">
                <a href="#" class="nav-link ml-3" @click="activeTab = '3'" activeClass="nav-item active">
                <i class="far fa-circle"></i>
                  <p>Meeting</p>
                </a>
              </router-link>
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/admin/setting" class="nav-link" @click="activeTab = '4'" activeClass="nav-item active">
              <i class="fas fa-cogs"></i>
              <p>
                Event setting
              </p>
            </router-link>
          </li>
          <li>
            <router-link to="/admin/profileEdit" class="nav-link" @click="activeTab = '5'" activeClass="nav-item active">
                <i class="fas fa-user-edit"></i>
                <p>
                  Edit profile
                </p>
            </router-link>
          </li>
    </div> 
</template>

<script>
export default {
    name: 'AdminSilder',
    props:[

      'invitee'
    ]
    ,
    data () {
        return{
          activeTab: '1',
        }
    }
}
</script>

<style lang="sass" scoped>

</style>