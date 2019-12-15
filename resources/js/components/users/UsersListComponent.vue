<template>
    <div id="user-list">
        <!-- navbar search -->
            <nav class="navbar sticky-top navbar-light bg-light mb-3 justify-content-center">
                
                <form class="form-inline my-2 my-lg-0">
                    <label for="#search">Search&nbsp;&nbsp;</label>
                    <select v-model="searchUser" name="" id="search" class='form-control mr-sm-2 mb-2'>
                        <option value=''>All</option>
                        <option :hidden='invitee.user_type === "Company"'>Company</option>
                        <option :hidden='invitee.user_type === "Innovator"'>Innovator</option>
                        <option :hidden='invitee.user_type === "Exhibitor"'>Exhibitor</option>
                    </select>
                    <div class='my-sm-3'>
                        <label class='d-inline' for="" style="color: #ff6464;">Users Count &nbsp;&nbsp;</label>
                        <button type="button" class="btn btn-secondary d-inline disabled">{{resultSearch}}</button>

                    </div>
                </form>

                
                
            </nav>
    <div class="container-fuild px-5">
        <div class="row">
            <!-- **meeting:owner** -->
                <!--|   id    |
                    |  name   |
                    |  email  |
                    |user_type|
                    |  Photo  | -->
        
            
                <UserCard 
                    v-for="user in filteredList"
                    :key="user.id"
                    :id="user.id"
                    :name="user.first_name"
                    :email="user.email"
                    :type="user.user_type"
                    :img="user.avatar"
                />
           
        </div>
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
        users: [],
        searchUser: '',
        resultSearch: 0
    }),
    computed: {
        filteredList() {
            this.resultSearch =
                this.users.filter(user => {
                return user.user_type.toLowerCase().includes(this.searchUser.toLowerCase())
            }).length
            
            return this.users.filter(user => {
                return user.user_type.toLowerCase().includes(this.searchUser.toLowerCase())
            })
            
        }
    },
    created(){
            axios.get('/v1/user/list/'+ this.invitee.id)
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
<style lang="scss" scoped>
    #user-list > nav{
        background-color: #ffffff !important;
    }
</style>