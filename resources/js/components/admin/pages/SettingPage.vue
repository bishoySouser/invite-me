<template>
    <div id='setting-page'>

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
           
                <div class="row">
                    
                    <div class="col-md-6 setting">
                    <!-- Event name -->
                        <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-hand-lizard"></i>
                            event name
                            </h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                            
                                <div class="input-group">
                                    <input type="text" v-model="eventName" name="event-name" placeholder="Eneter event name ..." class="form-control" :disabled='disabled'>
                                    <span class="input-group-append">
                                    <p class="btn btn-primary">Event Name</p>
                                    </span>
                                </div>
                            
                        </div>
                        <!-- /.card-body-->
                        </div>
                        <!-- time -->
                        <div class="card card-primary card-outline time">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="far fa-clock"></i>
                            Event Time
                            </h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                                <div class="form-row">
                                     <div class="col">
                                         <label>Start</label>
                                        <date-picker
                                            v-model="timeFrom" 
                                            type="time" 
                                            value-type="format" 
                                            format="HH:mm"
                                            placeholder="Event Start"
                                            :disabled='disabled'>
                                        </date-picker>
                                        
                                    </div>
                                    <div class="col">
                                        <label>End</label>
                                        <date-picker v-model="timeTo" 
                                        lang="en" 
                                        type="time"
                                        value-type="format" 
                                        format="HH:mm" 
                                        placeholder="Event End"
                                        :disabled='disabled'></date-picker>
                                    </div>
                                </div>
                        </div>
                        <!-- /.card-body-->
                        </div>
                        <!-- Date -->
                        <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Event Days
                            </h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="addItem">
                                <div class="input-group">
                                    <date-picker lang="en" input-name='date'
                                        class="form-control"
                                    v-model="newDate" valueType="format" :disabled='disabled'>
                                    </date-picker>
                                    <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary" :hidden="disabled">Add</button>
                                    </span>
                                </div>
                            </form>
                            <ul class="todo-list mt-2" >
                                <li class="text-center" v-for="item in dateList" :key="item.index">
                                    <label>{{item.event_date}}</label>
                                    <button @click="deleteItem(item,item.id)" type="button" class="btn btn-danger" :hidden="disabled">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </li>
                                
                            </ul>
                        </div>
                        <!-- /.card-body-->
                        </div>
                    <!-- /.card -->
                    </div>
                    <div class="col-md-6 setting">

                        <div class="card card-primary card-outline bg-gradient-success">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-save"></i>
                            Save Edit
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="col">
                               <button type="button" :class="[buttonEdit ? 'btn btn-light' : 'btn btn-success']" @click="editToggle">Edit</button>
                               <button type="button" class='btn btn-outline-warning float-right' @click="saveChange">Save Change</button>
                            </div>
                        </div>
                        <!-- /.card-body-->
                        </div>

                    </div>

                </div>
        </section>  

    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
export default {
    name:"SettingPage",
    components: { DatePicker },
    data() {
        return{
            title: 'Setting',
            dateList:[],
            newDate:'',
            timeFrom:'',
            timeTo: '',
            buttonEdit: false,
            disabled: false,
            eventName:''
        }
    },
    methods:{
        // TodoDates
        addItem(){
            var value = this.newDate && this.newDate.trim();
            if (!value) {
                alert('Date is empty.');
                return;
            }
            axios.post('v1/event/date', {
                event:1,
                event_date:this.newDate
            })
            .then((res) => {
                console.log(res)
                this.dateList.push({
                'event':1,
                'event_date':this.newDate,
            })
            this.newDate = '' 

            })
            
        },
        deleteItem(todo,id){
            console.log(id)
            axios.delete('v1/event/date/' + id)
            .then((res) => {
                const todoIndex = this.dateList.indexOf(todo)
                this.dateList.splice(todoIndex, 1)
            })
            
        },
        // End TodoDates
        editToggle(){
            this.buttonEdit = !this.buttonEdit
            this.disabled = !this.disabled
            // console.log('click editToggle');
        },
        saveChange(){
            axios.put('/v1/event', {
                id: 1, //1 because event table has one row .it has id => 1
                name: this.eventName,
                event_start: this.timeFrom,
                event_end: this.timeTo,
                edit: this.buttonEdit
            })
            .then((res) => {
                // console.log(res)
                location.reload()
            })
        },
        getEventInfo(){ /*Event Info (get)*/
             axios.get('/v1/event')
            .then((res) => {
                this.eventName = res.data.event_info.name
                this.timeFrom = res.data.event_info.event_start
                this.timeTo = res.data.event_info.event_end
                this.buttonEdit = res.data.event_info.edit
                this.dateList = res.data.dates
                // console.log(res.data.event_info)
            })
        }
    },
    watch:{
        buttonEdit: function(val){
            this.disabled = !val
        }
    },
    created(){
        this.getEventInfo()
    }
}
</script>
<style lang="scss" scoped>
.todo-list li{
    border-bottom: 1px solid #ced4da;
}

form > div > div{
    padding: 0px !important;
}

.save-edit .card {
    box-shadow: 1px 2px 5px 2px green
}

.setting .card button{
    border: 1px solid #ffffff6b;
}

</style>