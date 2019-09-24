<template>
    <div :id="'model'+id" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" @submit.prevent="onSubmit">
                        <div class="form-group row">
                            <label for="inputInvitee" class="col-sm-2 col-form-label">Inivtee</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="invitee" id="inputInvitee" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSubject" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="form.subject" placeholder="subject" id="inputSubject" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" v-model="form.description" placeholder="description" rows="3" id="inputDescription" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <date-picker lang="en" v-model="form.date" valueType="format"></date-picker>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                            <div class="col-sm-10">
                                 <date-picker lang="en" type="time" v-model="time" value-type="format" format="HH:mm:ss" :time-picker-options="timePickerOptions" placeholder="Select Time"></date-picker>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary float-right">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DatePicker from 'vue2-datepicker';

export default {
    name:'ModelMeeting',
    props: [
        'id',
        'inviteeId',
        'inviteeName'
    ],
    components: { DatePicker },
    data () {
        return{
            invitee: this.inviteeName,
            time:"",
            feedback:[],
            form: {
                owner:this.id,
                invitee:this.inviteeId,
                subject:"",
                description:"",
                date:"",
                start_time:""
            },
            timePickerOptions:{
                start: '9:00',
                step: '00:30',
                end: '22:00'
            }
        }
    },
    methods:{
        onSubmit: function(){
            const config = { headers: { "Content-Type": "multipart/form-data" } };
            const formData = new FormData();
            formData.append("owner", this.form.owner);
            formData.append("invitee", this.form.invitee);
            formData.append("subject", this.form.subject);
            formData.append("description", this.form.description);
            formData.append("date", this.form.date);
            formData.append("start_time", this.form.start_time);   
        
            axios
            .post('./api/v1/meeting/create', formData,config)
            .then( function(response){
                
            // console.log(event.target.value);
            })
            .catch(error => {
                const arr = error.response.data.errors;
                for(i=0; i <= arr.length ; i++){
                    this.feedback.push(arr[i]);
                }
                
                console.log(this.feedback);
            });
            }
        },
    watch:{
        time: function(val){
            const f = this.form //var equel form object
            f.start_time = val.slice(0,8); // delete am or pm
        }
    }
}
</script>
<style lang="scss" scoped>

</style>