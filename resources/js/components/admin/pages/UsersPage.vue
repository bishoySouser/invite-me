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

        <section class="content">
          <div class="row">
            <div class="col-6 col-sm-6">


            
            <div class="small-box bg-gradient-success">
              <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
            </div>

          </div>
        </section>

    </div>
</template>

<script>
export default {
    name:"UsersPage",
    data() {
        return{
            title: 'Users'
        }
    }
}
</script>

<style lang="sass" scoped>

</style>