<template>
    <div id='meeting-panding'>
        <h4>Meetings are Panding</h4>
        <router-link to="/meeting/confirm">List meetings are confrim</router-link>
        <meeting-list-component
                :owerid="id"
                 />   
    </div>
</template>
<script>
import MeetingList from '../meetings/MeetingsListComponent.vue'
export default {
    name:"MeetingPanding",
    props:[
        'id'
    ],
    components: {
        MeetingList
    },
    data(){
        return{

        }
    },
}
</script>

<style lang="scss" scoped>

</style>