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
                        <div class="row justify-content-md-center">
                            <div class="form-group col-md-12" style="display:contents">
                            <label for="meetingNumber" class="">Meeting Number: </label>
                                <p id="meetingNumber" style="font-family: cursive;">
                                {{form.meetingNum}}
                                </p>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <label for="inputInvitee" class="col-sm-2 col-form-label">Inivtee</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="invitee" id="inputInvitee" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSubject" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" name="subject"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('subject') }" 
                                    v-model="form.subject" placeholder="subject" id="inputSubject">
                                <has-error :form="form" field="subject"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="description"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('description') }" 
                                    v-model="form.description" placeholder="description" rows="3" id="inputDescription"></textarea>
                                <has-error :form="form" field="description"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <select id="dateMeeting" class="mx-datepicker form-control" v-model="form.date">
                                    <option hidden>choose</option>
                                    <option v-for='date in datesEvent' :key="date.index">{{date.event_date}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                            <div class="col-sm-10">
                                 <date-picker lang="en" input-name='start_time' 
                                 class="form-control"
                                :class="{ 'is-invalid': form.errors.has('start_time') }"
                                 type="time" v-model="time" value-type="format" format="HH:mm:ss"
                                  
                                 :time-picker-options="timePickerOptions" placeholder="Select Time">
                                 </date-picker>
                                 <has-error :form="form" field="start_time"></has-error>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right" 
                        :disabled='form.subject.length < 3 || form.description.length < 10 || form.date == "choose" || form.start_time == "Select Time"'>
                        Save changes
                        </button>
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
            now: moment().format("YYYY-MM-DD"),
            invitee: this.inviteeName,
            time:"",
            disabledTime: [],
            oldDate:'',
            hiddenTime:[],
            disabledDates: ['2019'],
            datesEvent:[],
            form: new Form({
                owner:this.id,
                invitee:this.inviteeId,
                subject:"",
                description:"",
                date:"choose",
                start_time:"Select Time",
                meetingNum: Math.floor(new Date().valueOf() * Math.random())
            }),
            timePickerOptions:{
                start: '9:00',
                step: '00:30',
                end: '22:00'
            }
        }
    },
    methods:{
        bookMeeting(owner,invitee,date){
            axios.get('/v1/meeting/'+owner+'/'+invitee+'/'+date)
            .then(res => {
                this.disabledTime = res.data
            })
        },
        handlePanelChange(date, owner , invitee){
            axios.get('/v1/meeting/'+owner+'/'+invitee+'/'+date)
            .then(res => {
                if(this.oldDate != this.form.date){
                    this.oldDate = this.form.date
                    this.disabledTime = res.data
                    this.hiddenTime = []
                    console.log('delete')
                    $('.mx-time-picker-item.cell').show();
                    for(let i=0; i < this.disabledTime.length ;i++){
                        let str = this.disabledTime[i].slice(0, -3); //remove second :00 like this 9:00:00 to 9:00
                        $('li:contains('+str+')')[0].style.display = 'none' // remove
                        this.hiddenTime.push(str)
                        this.time = ''
                    }
                }else{
                    this.oldDate = this.form.date
                    this.disabledTime = res.data
                    this.hiddenTime = []
                    console.log('diff')
                    $('.mx-time-picker-item.cell').show();
                    for(let i=0; i < this.disabledTime.length ;i++){
                        let str = this.disabledTime[i].slice(0, -3); //remove second :00 like this 9:00:00 to 9:00
                        $('li:contains('+str+')')[0].style.display = 'none' // remove
                        this.hiddenTime.push(str)
                        this.time = ''
                    }
                }
            })


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

        onSubmit(){  
              this.$Progress.start();
                this.form.post('/v1/meeting')
                .then((response)=>{
                    // console.log(response.data.msg);
                    this.form.reset();
                    this.time = "";
                    $('#model'+this.id).modal('hide')
                   toast.fire({
                        type: 'success',
                        title: response.data.msg
                        })
                })
                this.$Progress.finish();
                    
            }
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

form > div:nth-child(6) > div > div{
    padding: 0px !important;
}
form > div:nth-child(7) > div > div{
    padding: 0px !important;
}

</style>