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
                                <input type="text" class="form-control" v-model="subject" placeholder="subject" id="inputSubject">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" v-model="description" placeholder="description" rows="3" id="inputDescription"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <date-picker lang="en" v-model="date" valueType="format"></date-picker>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                            <div class="col-sm-10">
                                 <date-picker lang="en" type="time" v-model="time" format="HH:mm a" :time-picker-options="timePickerOptions" placeholder="Select Time"></date-picker>
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
        'inviteeName',
    ],
    components: { DatePicker },
    data () {
        return{
            meeting_owner:'',
            invitee: this.inviteeName,
            subject:'',
            description:'',
            date:'',
            time:''
            ,
            timePickerOptions:{
                start: '9:00',
                step: '00:30',
                end: '22:00'
      }}
    },
    methods:{
        onSubmit: function(){
            const formData = new FormData();
            formData.append("meeting_owner", this.meeting_owner);
            formData.append("invitee", this.invitee);
            formData.append("subject", this.subject);
            formData.append("description", this.description);
            formData.append("date", this.date);
            formData.append("time", this.time);   
            console.log(formData);
        }
    }
}
</script>
<style lang="scss" scoped>

</style>