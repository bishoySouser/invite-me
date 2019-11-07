<template>
    <div id='meetings-page'>

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

    </div>
</template>

<script>
export default {
    name:"MeetingsPage",
    data() {
        return{
            title: 'Meetings'
        }
    }
}
</script>

<style lang="sass" scoped>

</style>