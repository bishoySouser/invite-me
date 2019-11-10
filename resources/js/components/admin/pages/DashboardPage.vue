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
                            <h3>150</h3>

                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="/admin/users" class="small-box-footer">Edit <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53</h3>

                            <p>Meetings</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <a href="/admin/meeting" class="small-box-footer">Edit <i class="fas fa-arrow-circle-right"></i></a>
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
                  <i class="far fa-chart-bar"></i>
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
                <donut-chart 
                  id="donut" 
                  :data="donutData" 
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
                  <i class="far fa-chart-bar"></i>
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
                  :data=data
                  xkey="day"
                  ykeys='["Meeting"]' 
                  bar-colors='["blue"]' 
                  labels='["Meeting"]'   
                  grid-text-weight="bold"
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
export default {
    name:"DashboardPage",
    components: {
    DonutChart, BarChart
    },
    data() {
        return{
            title: 'Dashboard',
            donutData: [
              { label: 'Companies', value: 50 },
              { label: 'Expeditors', value: 70 },
              { label: 'Innovators', value: 80 },
              { label: 'Visitors', value: 100 },
            ],
            data: [
              { day: "5-11-2019", Meeting: 2 },
              { day: "6-11-2019", Meeting: 3 },
              { day: "7-11-2019", Meeting: 2 },
              { day: "8-11-2019", Meeting: 1 }
            ]
        }
    }
}
</script>

<style lang="sass" scoped>

</style>