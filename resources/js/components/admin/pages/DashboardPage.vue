<template>
    <div id='dashboard-page'>

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{title}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">{{title}}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <section class="content counter">
            
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{users}}</h3>

                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="/admin/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{meetings}}</h3>

                            <p>Meetings</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <a href="/admin/meeting" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                
            </div>
        </section>


    <!-- Main content -->
    <section class="content analysis">
        <div class="row">
          
          <!-- /.col -->

          <div class="col-md-6">
            <!-- Donut chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-users"></i>
                  Users
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <loading :active.sync="isLoading" 
                :can-cancel="true" 
                :on-cancel="onCancel"
                :is-full-page="fullPage"></loading>
                <donut-chart 
                  id="donut" 
                  :data=" [
                    {label: 'Companies', value: companies},
                    { label: 'Expeditors', value: expeditors},
                    { label: 'Innovators', value: innovators}
                  ]" 
                  colors='[ "#FF6384", "#36A2EB", "#FFCE56", "#FFF000"]' 
                  resize="true">
                </donut-chart>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          

          <div class="col-md-6">
            <!-- Donut chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-handshake"></i>
                  Meetings
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <bar-chart id="bar"
                  :data=" [
                    { status: 'approved', Meeting: approved},
                    { status: 'pending', Meeting: pending},
                  ]" 
                  xkey="status"
                  ykeys='["Meeting"]' 
                  bar-colors='["blue"]' 
                  labels='["Meeting"]'   
                  grid-text-weight=""
                  grid="true" 
                  resize="true" >
                </bar-chart>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
    </section>
        
    </div>
</template>

<script>
import Vue from 'vue'
import { DonutChart, BarChart } from 'vue-morris'
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    name:"DashboardPage",
    components: {
    DonutChart, BarChart, Loading
    },
    data() {
        return{
            title: 'Dashboard',
            users: null,
            meetings: null,
            companies: 1,
            expeditors: 1,
            innovators: 1,
            approved:0,
            pending:0,
            isLoading: false,
            fullPage: true
        }
    },
    methods:{
      //Users and Meetings Count
      uamCount(){
         axios.get('v1/info/uam')
            .then((res) => {
                this.users = res.data.data.UserAll
                this.meetings = res.data.data.Meetings
                this.companies = res.data.data.Companies
                this.expeditors = res.data.data.Exhibitors
                this.innovators = res.data.data.Innovators
            })
      },
      getMeetingStatusCount(){
        axios.get('v1/admin/statusCount')
            .then((res) => {
                this.approved = res.data.approved;
                this.pending = res.data.pending;
                // console.log(res)
            })
      },
      loadinglazy() {
          this.isLoading = true;
          // simulate AJAX
          setTimeout(() => {
            this.isLoading = false
          },500)
      },
      onCancel() {
        console.log('User cancelled the loader.')
      }
    },
    created(){
      this.uamCount();
      this.getMeetingStatusCount();
      this.loadinglazy()
    }
}
</script>

<style lang="sass" scoped>

</style>