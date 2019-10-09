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
                <tr v-for='(value, index) in list'>
                    <th scope="row">{{index+1}}</th>
                    <td>{{value.invitee.first_name}}</td>
                    <td>{{value.date_meeting}}</td>
                    <td><a href="#" data-toggle="modal" :data-target="'#Modal'+value.id">Info</a></td>
                    <!-- Modal -->

                    <td>
                        <button type="button" class="btn btn-success">Confirm</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info">Change Time</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger">Reject</button>
                    </td>
                    <!-- model -->
                    <div class="modal fade" :id="'Modal'+value.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="status text-center bg-info text-white">
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
export default {
    name:'meetingList',
    props:[
        'owerid'
    ],
    data () {
        return{
            list: [] 
        }
    },
    methods:{
        getMeetingList(){
            axios.get('/v1/meeting/'+this.owerid)
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
//model
.modal .modal-body span{
    font-weight: bold;
    font-size: 20px;
    color: #000;
}
.modal .modal-body p{
    color: #dd3011;
}
</style>