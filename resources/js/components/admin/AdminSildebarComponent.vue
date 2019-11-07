<template>
   <div id='admin-slidbar'>
          <li class="nav-item has-treeview menu-open">  
              <router-link to="/admin" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </router-link>
          </li>
         <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-grip-horizontal"></i>
              <p>
                Category
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <router-link tag="li" to="/admin/users" class="nav-item">
                <a href="#" class="nav-link">
                <i class="far fa-circle"></i>
                  <p>User</p>
                </a>
              </router-link>
              <router-link tag="li" to="/admin/meeting" class="nav-item">
                <a href="#" class="nav-link">
                <i class="far fa-circle"></i>
                  <p>Meeting</p>
                </a>
              </router-link>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Setting
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
    </div> 
</template>

<script>
export default {
    name: 'AdminSilder',
    data () {
        return{
        }
    }
}
</script>

<style lang="sass" scoped>

</style>