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
                <input class="form-control form-control-navbar rounded-pill" type="search" placeholder="Search by email" aria-label="Search">
              </div>
            </form>
            
            <button class="btn btn-success float-right" style="flex-flow: row-reverse;" data-toggle="modal" data-target="#meetingCreate">
                Create Meeting
            </button>
          
        </nav>

        <!-- User Registration Model -->
        <div class="modal fade" id="meetingCreate" tabindex="-1" role="dialog" aria-labelledby="UserRegistration" aria-hidden="true">
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
import DatePicker from 'vue2-datepicker';
export default {
    name:"MeetingsPage",
    components: { DatePicker },
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
        }
    },
    methods:{
      meetingCreate(){
        console.log('create meeting')
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
      }
    },
    created(){
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