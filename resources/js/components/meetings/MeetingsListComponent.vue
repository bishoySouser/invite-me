<template>
    <div id="meeting-list">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Invitee</th>
                <th scope="col">Date</th>
                <th scope="col">Details</th>
                <th scope="col" colspan="3" class="text-center">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for='(value, index) in list' :key="index" class="text-center">
                    <th scope="row">{{index+1}}</th>
                    <td v-if="value.invitee_id != owerid">{{value.invitee.first_name}}</td>
                    <td v-if="value.owner_id != owerid">{{value.owner.first_name}}</td>
                    <td>{{value.date_meeting}}</td>
                    <td><a href="#" data-toggle="modal" :data-target="'#Modal'+value.id">Info</a></td>
                    <!-- Modal -->

                    <td>
                        <span class="fade-in" v-show="value.status != 'pending'" style="color: #15c74ca3;">
                                <i class="fas fa-check fa-2x"></i>
                        </span>
                        <button type="button" class="btn btn-success" v-if="value.status == 'pending'" :disabled="value.status != 'pending'" @click="confirmMeeting(value)">
                            Confirm
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info"  :disabled="value.status != 'pending'" data-toggle="modal" :data-target="'#ModalChMeeting'+value.id">Change Time</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" :disabled="value.status != 'pending'" @click="deleteMessage(value,value.id)">Reject</button>
                    </td>
                    <ModelChangeTime @change-mode="changeMode(value)" :userId="owerid" :meeting='value'/>
                    <!-- model info -->
                    <div class="modal fade text-left" :id="'Modal'+value.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Meeting Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <p>
                                                    <span>Invitee:</span>
                                                    {{value.invitee.first_name}}
                                                </p>
                                            </div>
                                            <div class="col">
                                                <p>
                                                    <span>Subject:</span>
                                                    {{value.subject }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>
                                                    <span>Description:</span>
                                                    {{value.description}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>
                                                    <span>Date:</span>
                                                    {{value.date_meeting}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>
                                                    <span>Form:</span>
                                                    {{value.start_time}}
                                                </p>
                                            </div>
                                            <div class="col">
                                                <p>
                                                    <span>To:</span>
                                                    {{value.finish_time }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="status text-center text-white" :class="(value.status == 'pending') ? 'bg-info' : 'bg-success'">
                                    {{value.status}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end model -->
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import ModelChangeTime from "../models/ModelChangeTimeComponent"
export default {
    name:'meetingList',
    props:[
        'owerid'
    ],
    components: {
        ModelChangeTime
    },
    data () {
        return{
            list: [],
            idItemDelete: ''
        }
    },
    methods:{
        changeMode(value){
            value.status= 'change Time'
            console.log(value);
            let index = this.list.indexOf(value)
            this.list.splice(index, 1);
            
        },
        getMeetingList(){
            axios.get('/v1/meeting/' + this.owerid)
            .then((res) => {
                this.list = res.data.list
            })
        },
        confirmMeeting(value){
            value.status = 'approved'
            axios.put('/v1/meeting', {
                id: value.id,
                do_order: this.owerid,
                status: value.status
            })
            .then((res) => {
                console.log(res)
            })
        },
        deleteMessage(value,id){
            this.idItemDelete = id;
            console.log(value)
            axios.delete('/v1/meeting/' + id)
            .then((res) => {
                let index = this.list.indexOf(value)
                this.list.splice(index, 1);
            })
        }
    },
    created(){
        this.getMeetingList()
        Echo.join('meetingcreate')
                // .here()
                // .joining()
                // .leaving()
                .listen('MeetingPosted', (e) => {
                    
                    this.list.push(e.meeting)
                })
    }
    
}
</script>

<style lang="scss" scoped>
//model
.modal .modal-body span{
    font-weight: bold;
    font-size: 20px;
    color: #000;
}
.modal .modal-body p{
    color: #dd3011;
}

//fade-in
.fade-in {
  animation: fadeIn ease 2s;
  -webkit-animation: fadeIn ease 2s;
  -moz-animation: fadeIn ease 2s;
  -o-animation: fadeIn ease 2s;
  -ms-animation: fadeIn ease 2s;
}


@keyframes fadeIn{
  0% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}
</style>