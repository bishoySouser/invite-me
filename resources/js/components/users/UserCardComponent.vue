<template>
    <div id="user_card" class="col-4">
        <div class="card" style="width: 10rem;">
        <img src="#" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{name}}</h5>
            <p class="card-text">{{email}}</p>
            <a class="btn btn-primary" data-toggle="modal" :data-target="'#model'+id">Meeting</a>
            <a class="btn btn-primary" data-toggle="modal" data-target="#modelMs">Message</a>
        </div>
        </div>
        
    </div>
</template>
<script>
export default {
    name: 'UserCard',
    props:[
        'id',
        'name',
        'email',
        'type'
    ]
}
</script>
<style lang="stylus" scoped>

</style>