<template>
    <div id="user_card" class="col-lg-3 col-md-4 col-sm-6">
        <div class="card card-block">

            <img v-if='img == null' src="/img/profilePicturePlaceholder.png" class="card-img-top rounded" style="height: 180px; width: 100%;">
                <img v-else :src="'/img/profile/'+img" class="card-img-top rounded" style="height: 180px; width: 100%;">
            
            <div class='card-body'>

                <h5 class="card-text">{{name}}<p class="card-text">{{email}}</p></h5>
                <h4>{{type}}</h4>
                
                <a class="btn bg-primary text-white" data-toggle="modal" :data-target="'#model'+id">Meeting <i class="fas fa-handshake"></i></a>
                <a class="btn bg-success text-white" data-toggle="modal" :data-target="'#modelMs'+id">Message <i class="far fa-envelope"></i></a>
            </div>

        </div>
                
        
        <!-- <div class="card m-2" style="width: 18rem;">
            <img v-if='img == null' src="/img/profilePicturePlaceholder.png" class="card-img-top img-thumbnail">
            <img v-else :src="img" class="card-img-top">
        
            <div class="card-body">
                <h5 class="card-title">{{name}}</h5>
                <p class="card-text">{{email}}</p>
                <a class="btn btn-primary" data-toggle="modal" :data-target="'#model'+id">Meeting</a>
                <a class="btn btn-primary" data-toggle="modal" :data-target="'#modelMs'+id">Message</a>
            </div>
        </div> -->
        
    </div>
</template>
<script>
export default {
    name: 'UserCard',
    props:[
        'id',
        'name',
        'email',
        'type',
        'img'
    ]
}
</script>
<style lang="stylus" scoped>

</style>