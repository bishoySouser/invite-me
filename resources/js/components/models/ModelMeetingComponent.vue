<template>
    <div :id="'model'+id" :class="'modal'+id+' fade bd-example-modal-lg'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/home">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="form-group row">
                            <label for="inputInvitee" class="col-sm-2 col-form-label">Inivtee</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" :value="name" id="inputInvitee" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSubject" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="subject" id="inputSubject">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" placeholder="description" rows="3" id="inputDescription"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <date-picker v-model="value1" lang="en" valueType="format"></date-picker>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                            <div class="col-sm-10">
                                 <date-picker v-model="value2" lang="en" type="time" format="hh:mm:ss a" :time-picker-options="timePickerOptions" placeholder="Select Time"></date-picker>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        'name'
    ],
    components: { DatePicker },
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        value1: '',
        value2: '',
        value3: '',
        timePickerOptions:{
            start: '9:00',
            step: '00:30',
            end: '22:00'
      }
    })
}
</script>
<style lang="scss" scoped>

</style>