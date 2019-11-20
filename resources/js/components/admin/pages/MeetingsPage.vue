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
                <input class="form-control form-control-navbar rounded-pill" type="search" v-model="meetingSearch" placeholder="Search by Meeting num" aria-label="Search">
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
                  <td style='background: #fff;'>{{meeting.start_time}}
                    <span style='display: block;'>{{meeting.date_meeting}}</span>
                  </td>
                  <td style='background: #fff;'>{{meeting.status}}</td>
                  <td style='background: #fff;'>
                    <button class='btn btn-primary'>Edit</button>
                  </td>
                  <td style='background: #fff;'>
                    <button class='btn btn-danger'>Delete</button>
                  </td>

                </tr>
                  
                  <!-- Modal delete -->
                  <!-- <div class="modal fade" :id="'model'+user.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Delete "{{user.first_name+' '+user.last_name}}" ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                          <button type="button" class="btn btn-danger" @click="deleteUser(user.id)">Yes</button>
                        </div>
                      </div>
                    </div>
                  </div> -->
                
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
            meetingNum: Date.now()+Math.floor(Math.random() * 101),
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
            meetingSearch:''
        }
    },
    computed: {
        filteredList() {
            return this.meetings.filter(meeting => {
                return meeting.meetingNum.toString().includes(this.meetingSearch)
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
          console.log(res);
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
</style>