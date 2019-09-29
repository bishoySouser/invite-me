<template>
    <div id="user-list">
        <div  class="row justify-content-center text-center">
            <!-- **meeting:owner** -->
                <!--|   id    |
                    |  name   |
                    |  email  |
                    |user_type| -->
            <UserCard 
                v-for="user in users"
                :key="user.id"
                :id="user.id"
                :name="user.first_name"
                :email="user.email"
                :type="user.user_type"
             />
        </div>
            <!-- **meeting:owner** -->
                <!--|   id    |
                    |  name   |-->
                <!-- **invitee** -->
                <!--| inviteeId |
                    |inviteeName|-->
        <MeetingModel 
            v-for="value in users"
            :key="value.id"
            :id="value.id"
            :name="value.first_name"
            :inviteeId="invitee.id"
            :inviteeName="invitee.first_name"
        />
                <!-- **receiver** -->
                <!--|   id    |
                    |  receiver   |-->
                <!-- **sender** -->
                <!--| id |
                    |sender |-->
        <ModelMessage 
        v-for="receiver in users"
        :key="receiver.num"
        :id="receiver.id"
        :receiver="receiver.first_name"
        :senderId="invitee.id" />
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>
<script>
import UserCard from "./UserCardComponent";
import MeetingModel from "../models/ModelMeetingComponent";
import ModelMessage from "../models/ModelMessageComponent";
export default {
    name:'UserList',
    props:[
        'invitee'
    ],
    components: {
        UserCard,
        MeetingModel,
        ModelMessage
    },
    data: () => ({
        users: []
    }),
    created(){
            axios.get('./api/v1/user/list/'+ this.invitee.id)
             .then((res) => {
                this.users = res.data.users;
                // console.log(this.users);
            })
                .catch(({ response }) => {
                this.errors = response.data.errors;
            });
    }
}
</script>
<style lang="stylus" scoped>

</style>