<template>
    <div id='Edit profile'>
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
       
        <PageProfile :user="userinfo"/>
    </div>
</template>

<script>
import PageProfile from '../../pages/PageProfile'
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    name:"EditProfile",
    props:[
      'userinfo'
    ],
    components: {
            Loading,
            PageProfile
        },
    data() {
        return{
            title: 'Edit Profile',
        }
    }
}
</script>

<style lang="sass" scoped>

</style>