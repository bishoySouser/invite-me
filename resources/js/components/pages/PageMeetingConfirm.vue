<template>
    <div id='meeting-confirm'>
        <h4>Meetings are Confrim</h4>
        <router-link to="/meeting">List meetings are panding</router-link>
        <table class="table">
            <thead class="thead-dark text-center">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Invitee</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for='(value, index) in list' :key="index" class="text-center">
                    <th scope="row">{{index+1}}</th>
                    <td v-if="value.invitee_id != id">{{value.invitee.first_name}}</td>
                    <td v-if="value.owner_id != id">{{value.owner.first_name}}</td>
                   
                    <td>{{value.date_meeting}}</td>
                    <td>{{value.start_time.slice(0, -3)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name:"MeetingConfirm",
    props:[
        'id'
    ],
    data(){
        return{
            list: [],
        }
    },
    methods:{
        getMeetingList(){
            axios.get('/v1/meeting/approved/' + this.id)
            .then((res) => {
                this.list = res.data.list
            })
        }
    },
    created(){
        this.getMeetingList()
    }
}
</script>

<style lang="scss" scoped>

</style>