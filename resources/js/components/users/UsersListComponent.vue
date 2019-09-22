<template>
    <div id="user-list">
        <div  class="row justify-content-center text-center">
            <UserCard 
                v-for="user in users"
                :key="user.id"
                :id="user.id"
                :name="user.first_name"
                :email="user.email"
                :type="user.type"
             />
        </div>
        
        <MeetingModel 
            v-for="user in users"
            :key="user.id"
            :id="user.id"
            :name="user.first_name"
        />
    </div>
</template>
<script>
import UserCard from "./UserCardComponent";
import MeetingModel from "../models/ModelMeetingComponent";
export default {
    name:'UserList',
    props:[
        'num'
    ],
    components: {
        UserCard,
        MeetingModel
    },
    data: () => ({
        users: []
    }),
    created(){
            const baseUrl = 'http://localhost:8000/api/v1/';
            axios.get(baseUrl +'user/list/'+ this.num)
             .then((res) => {
                this.users = res.data.users;
                console.log(this.users);
            })
                .catch(({ response }) => {
                this.errors = response.data.errors;
            });
    }
}
</script>
<style lang="stylus" scoped>

</style>