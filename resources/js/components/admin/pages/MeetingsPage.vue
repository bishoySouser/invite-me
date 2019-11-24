<template>
    <div id='meetings-page'>

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{title}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active">{{title}}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                {{title}}
                </div>
            </div>
        </section>

        <nav class="navbar sticky-top" style="background: #f4f6f9;">
          
            <form class="form-inline ml-3 pr-2">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" v-model="meetingSearch" :placeholder="'Search by'+' '+ searchType" aria-label="Search">
                <select v-model="searchType" name="" id="">
                  <option>Meeting num</option>
                  <option>one to</option>
                  <option>one</option>
                </select>
              </div>
            </form>
            
            <button class="btn btn-success float-right" style="flex-flow: row-reverse;" data-toggle="modal" data-target="#meetingCreate">
                Create Meeting
            </button>
          
        </nav>

        <div class="meeting-list">
          <div class='row'>
            <table class="table text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#Num</th>
                  <th scope="col">One to</th>
                  <th scope="col">One</th>
                  <th scope="col">Date Time</th>
                  <th scope="col">Status</th>
                  <th scope="col" colspan="2">Handling</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for='meeting in filteredList' :key='meeting.index'>
                <!-- loading -->
                  <td style='background: cadetblue;color:#fff;font-weight: bold;'>{{meeting.meetingNum}}</td>
                  <td style='background: #fff;'>{{meeting.invitee.first_name+' '+meeting.invitee.last_name}}
                    <span style='display: block;'>{{meeting.invitee.email}}</span>
                  </td>
                  <td style='background: #fff;'>{{meeting.owner.first_name+' '+meeting.owner.last_name}}
                    <span style='display: block;'>{{meeting.owner.email}}</span>
                  </td>
                  <td style='background: #fff;'>
                    <a href="#" role="button" data-toggle="modal" :data-target="'#modalEdit'+meeting.id">
                      {{meeting.start_time}}
                      <span style='display: block;'>{{meeting.date_meeting}}</span>
                    </a>
                  </td>
                  <td style='background: #fff;'>{{meeting.status}}</td>
                  <td style='background: #fff;'>
                    <button class='btn btn-danger' data-toggle="modal" :data-target="'#model'+meeting.id">Delete</button>
                  </td>

                  <!-- edit time -->
                  <div class="modal fade" :id="'modalEdit'+meeting.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Meeting time</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="container text-monospace">
                                <div class="row d-block">
                                  <form method="POST" @submit.prevent="changeDate">
                                        <div class='form-group row'>
                                          <label for="inputDate" class="col-sm-6 col-form-label">Who need change date?</label>
                                          <select class='mx-datepicker form-control' v-model="orderDo" >
                                            <option value="Who need change date?" hidden>Who need change date?</option>
                                             <option :value='meeting.invitee.id'>{{meeting.invitee.email}}</option>
                                             <option :value='meeting.owner.id'>{{meeting.owner.email}}</option>
                                          </select>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                        <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                                            <div class="col-sm-10">                      
                                                <select class='mx-datepicker form-control' v-model="dateChange" id="">
                                                  <option value="Select Date" hidden>Select Date</option>
                                                  <option v-for='date in dates' :key="date.index">{{date.event_date}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                                            <div class="col-sm-10">
                                                <date-picker lang="en" input-name='start_time' 
                                                class="form-control"
                                                type="time" v-model='timeChange' value-type="format" format="HH:mm:ss" 
                                                :time-picker-options="timePickerOptions" placeholder="Select Time">
                                                <!-- :class="{ 'is-invalid': form.errors.has('start_time') }"
                                                :time-picker-options="timePickerOptions" placeholder="Select Time" -->
                                                </date-picker>
                                                <has-error :form="form" field="start_time"></has-error>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" @click='editDate(meeting.id)'
                          :disabled="orderDo == 'Who need change date?' || dateChange == 'Select Date' || timeChange == 'Select Time'">Save changes</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal delete -->
                  <div class="modal fade" :id="'model'+meeting.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delete Meeting</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Delete meeting number "{{meeting.meetingNum}}" ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                          <button type="button" class="btn btn-danger" @click='deleteMeeting(meeting, meeting.id)'>Yes</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </tr>
                  
              </tbody>
            </table>
          </div>
        </div>

        <!-- create meeting Model -->
        <div class="modal fade" id="meetingCreate" tabindex="-1" role="dialog" aria-labelledby="meetingCreate" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Meeting create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  
                  <form>
                    <div class="form-row">
                      <div class="form-group col-md-12" style="display:contents">
                        <label for="meetingNumber">Meeting Number: </label>
                        <p id="meetingNumber" class="px-2" style="font-family: cursive;">
                          {{meetingNum}}
                        </p>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="peroneOne">Persone one</label>
                        <select id="peroneOne" class="form-control" v-model='form.personeOne'>
                          <option disabled>choose</option>
                          <option v-for='user in users' :key="user.index" :value="user.id" :hidden='form.personeTwo == user.id'>{{user.email}}</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="personeTwo">Persone two</label>
                        <select id="personeTwo" class="form-control" v-model='form.personeTwo'>
                          <option disabled>choose</option>
                          <option v-for='user in users' :key="user.index" :value="user.id" :hidden='form.personeOne == user.id'>{{user.email}}</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="dateMeeting">Date</label>
                        <select id="dateMeeting" class="form-control" v-model="form.meetingDate">
                          <option disabled>choose</option>
                          <option v-for='date in dates' :key="date.index">{{date.event_date}}</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="meetingStatus">Time</label>
                        <date-picker lang="en" input-name='start_time' 
                          class="form-control"
                          type="time" v-model="form.meetingTime" value-type="format" format="HH:mm:ss"
                          :time-picker-options="timePickerOptions" placeholder="Select Time">
                        </date-picker>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="meetingStatus">Status</label>
                        <select id="meetingStatus" class="form-control" v-model="form.meetingStatus" disabled>
                          <option>approved</option>
                        </select>
                      </div>
                    </div>

                    
                    
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="meetingCreate()" :disabled="form.personeOne == 'choose' || form.personeTwo == 'choose' || form.meetingDate == 'choose'">Create</button>
              </div>
            </div>
          </div>
        </div> 

    </div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import DatePicker from 'vue2-datepicker';
export default {
    name:"MeetingsPage",
    components: { DatePicker , Loading },
    data() {
        return{
            title: 'Meetings',
            meetingNum: Math.floor(new Date().valueOf() * Math.random()),
            form: new Form({
              personeOne: 'choose',
              personeTwo: 'choose',
              meetingDate: 'choose',
              meetingTime: 'choose',
              meetingStatus: 'approved',
            }),
            timePickerOptions:{
                start: '9:00',
                step: '00:30',
                end: '22:00'
            },
            users:[],
            dates:[],
            meetings:[],
            meetingSearch:'',
            searchType:'Meeting num',
            dateChange: 'Select Date',
            timeChange:'Select Time',
            orderDo:'Who need change date?'
        }
    },
    computed: {
        filteredList() {
            return this.meetings.filter(meeting => {
              if(this.searchType == 'Meeting num'){
                return meeting.meetingNum.toString().includes(this.meetingSearch)
              }else if(this.searchType == 'one to'){
                return meeting.invitee.email.toLowerCase().includes(this.meetingSearch.toLowerCase())
              }else if(this.searchType == 'one'){
                return meeting.owner.email.toLowerCase().includes(this.meetingSearch.toLowerCase())
              }
            })
        }
    },
    methods:{
      meetingCreate(){
        axios.post('v1/meeting', {
          owner: this.form.personeTwo,
          invitee: this.form.personeOne,
          subject: 'Subject name',
          description: 'meeting from admin',
          date: this.form.meetingDate,
          start_time: this.form.meetingTime,
          meetingNum: this.meetingNum,
          status: this.form.meetingStatus
        })
        .then(res => {
          $('#meetingCreate').modal('hide')
            toast.fire({
              type: 'success',
              title: res.data.msg
            })
            location.reload();
        })
      },
      meetingInfo(){
        axios.get('v1/admin/infoMeeting')
        .then(res => {
          this.users = res.data.users
          this.dates = res.data.dates
          this.timePickerOptions.start = res.data.event.event_start
          this.timePickerOptions.end = res.data.event.event_end
          // console.log(res.data)
        })
      },
      getMeetings(){
        axios.get('v1/admin/meetings')
        .then(res => {
          this.meetings = res.data.list 
          // console.log(res);
        })
      },
      editDate(meetingId){
        axios.put('v1/meeting/status',{
          id: meetingId,
          do_order: this.orderDo,
          date: this.dateChange,
          start_time: this.timeChange 
        })
        .then(res => {
          $('#modelEdit'+meetingId).modal('hide')
            toast.fire({
              type: 'success',
              title: res.data.msg
            })
            location.reload();
          console.log(this.orderDo+' '+this.dateChange+' '+this.timeChange)
        })
      },
      deleteMeeting(value,id){
        axios.delete('/v1/meeting/' + id)
        .then(res => {
          $('#model'+id).modal('hide')
          let index = this.meetings.indexOf(value)
          this.meetings.splice(index, 1);
          toast.fire({
              type: 'error',
              title: res.data.msg
            })
          // console.log('delete meeting'+id)
        })
      }
    },
    created(){
      this.getMeetings()
      this.meetingInfo()
      document.title = this.title
    }
}
</script>

<style lang="scss" scoped>
  form > div:nth-child(3) > div:nth-child(2) > div{
    padding: 0px;
  }
  form > div:nth-child(4) > div > div{
    padding: 0px;
  }
</style>