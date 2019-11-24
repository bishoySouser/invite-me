<template>
        <div :id="'ModalChMeeting'+meeting.id" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Date</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="container text-monospace">
                                <div class="row d-block">
                                    <span class="h2 d-block">Old Date</span>
                                    <div class="text-monospace">
                                        <span class="font-weight-normal">{{meeting.date_meeting}}</span>
                                        <span class=" text-secondary">{{meeting.start_time}}</span>
                                    </div>
                                </div>
                                <hr>
                            
                                    <form method="POST" @submit.prevent="changeDate">
                                        <div class="form-group row">
                                        <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                                            <div class="col-sm-10">
                                                <select id="dateMeeting" class="mx-datepicker form-control" v-model="form.date">
                                                    <option hidden>choose</option>
                                                    <option v-for='date in datesEvent' :key="date.index">{{date.event_date}}</option>
                                                </select>
                                                <has-error :form="form" field="date"></has-error>
                                                <!-- class="{ 'is-invalid': form.errors.has('date') }"
                                                v-model="form.date" valueType="format" :disabled-days="disabledDates" -->
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                                            <div class="col-sm-10">
                                                <date-picker lang="en" input-name='start_time' 
                                                class="form-control"
                                                type="time" v-model="time" value-type="format" format="HH:mm:ss" 
                                                :class="{ 'is-invalid': form.errors.has('start_time') }"
                                                :time-picker-options="timePickerOptions" placeholder="Select Time" onkeydown="return false" :disabled='form.date < now'>
                                                <!-- :class="{ 'is-invalid': form.errors.has('start_time') }"
                                                :time-picker-options="timePickerOptions" placeholder="Select Time" -->
                                                </date-picker>
                                                <has-error :form="form" field="start_time"></has-error>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right">Save changes</button>
                                    </form>
                                
                            </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import ModelMeeting from './ModelMeetingComponent';
export default {
    name: 'ModelChangeTime',
    props: [
        'meeting',
        'userId'
    ],
    components: { DatePicker },
    mixins: [ModelMeeting],
    data() {
        return{
            time:"",
            form: new Form({
                id: this.meeting.id,
                datesEvent:[],
                date:"choose",
                start_time:"",
                do_order:this.userId
            }),
            timePickerOptions:{
                start: '9:00',
                step: '00:30',
                end: '22:00'
            }
        }
    },
    methods:{
        changeDate(){
            this.$Progress.start();
                this.form.put('v1/meeting/status')
                .then((response)=>{
                    // console.log(response.data.msg);
                    this.$emit('change-mode')
                    this.form.reset();
                    this.time = "";
                    $('#ModalChMeeting'+this.meeting.id).modal('hide')
                   toast.fire({
                        type: 'success',
                        title: response.data.msg
                        })
                })
                this.$Progress.finish();
        },
        meetingInfo(){
            axios.get('v1/admin/infoMeeting')
            .then(res => {
                
                this.datesEvent = res.data.dates
                this.timePickerOptions.start = res.data.event.event_start
                this.timePickerOptions.end = res.data.event.event_end
                console.log(res.data)
                })
        },
    },
    watch:{
        time: function(val){
            const f = this.form //var equel form object
            f.start_time = val.slice(0,8); // delete am or pm
        }
    },
    created(){
        this.meetingInfo();
    }
}
</script>

<style lang="scss" scoped>
form > div:nth-child(1) > div > div{
    padding: 0px !important;
}
form > div:nth-child(2) > div > div{
    padding: 0px !important;
}
</style>