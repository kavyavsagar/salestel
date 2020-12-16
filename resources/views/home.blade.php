@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-2 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner revenue">
            <div class="row"> 
              <div class="col-lg-6 col-md-6 col-12">
                <p class="text-warning">Last Month</p>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <h4>{{$neworders['new_last']}}</h4>               
              </div>
            </div>
            <hr>
            <div class="row"> 
              <div class="col-lg-6 col-md-6 col-12">
                <p >This Month</p>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <h4>{{$neworders['new_this']}}</h4>
                <small> Total Orders</small>
              </div>
            </div>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route('order.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-12">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner revenue">
            <div class="row"> 
              <div class="col-lg-2 col-md-2 col-12"><p class="text-warning">Last Month</p></div>
              <div class="col-lg-4 col-md-4 col-12">
                <h4 class="text-dark"><span title="{{$comporders['totalCnt'][0]}}">{{$comporders['totalAmt'][0]}} <sup style="font-size: 20px">AED</sup> | {{$comporders['totalCnt'][0]}}</span></h4>
      <!--           <p class="text-dark">Pending</p> -->
              </div>
              <div class="col-lg-4 col-md-4 col-12">
               <!--  <h4><span title="{{$comporders['completedCnt'][0]}}" >{{$comporders['completedAmt'][0]}} <sup style="font-size: 20px;">AED</sup> | {{$comporders['completedCnt'][0]}} </span></h4> -->
                <!--  <p>Completed</p> -->
              </div>
              <div class="col-lg-2 col-md-2 col-12">
                <h4 class="text-danger"><span title="{{$comporders['rejectedCnt'][0]}}" >{{$comporders['rejectedAmt'][0]}} <sup style="font-size: 20px;">AED</sup> | {{$comporders['rejectedCnt'][0]}} </span></h4>
 <!--                <p class="text-danger">Rejected</p> -->
              </div>
            </div>
            <hr/>
             <div class="row"> 
              <div class="col-lg-2 col-md-2 col-12"><p class="text-white">This Month</p></div>
              <div class="col-lg-4 col-md-4 col-12">
                <h4 class="text-dark"><span title="{{$comporders['totalCnt'][1]}}">{{$comporders['totalAmt'][1]}} <sup style="font-size: 20px">AED</sup> | {{$comporders['totalCnt'][1]}}</span></h4>
                <small class="text-dark">Pending</small>
              </div>
              <div class="col-lg-4 col-md-4 col-12">
                <h4><span title="{{$comporders['completedCnt'][1]}}" >{{$comporders['completedAmt'][1]}} <sup style="font-size: 20px;">AED</sup> | {{$comporders['completedCnt'][1]}} </span></h4>
                 <small class="text-white">Completed</small>
              </div>
              <div class="col-lg-2 col-md-2 col-12">
                <h4 class="text-danger"><span title="{{$comporders['rejectedCnt'][1]}}" >{{$comporders['rejectedAmt'][1]}} <sup style="font-size: 20px;">AED</sup> | {{$comporders['rejectedCnt'][1]}} </span></h4>
                <small class="text-danger">Rejected</small>
              </div>
            </div>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ route('order.complete') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$customers}}</h3>

            <p>Customers</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{ route('customer.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$complaints}}</h3>

            <p>Pending Complaints</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{ route('complaint.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    @hasanyrole('Coordinator|Admin|Team Lead')
    <div class="row">         
      <div class="col-md-12">
        <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Agent Sales</h3>
                  <a href="{{route('order.index')}}">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">AED 22,000.00</span>
                    <span>Sales Over The Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 
                    </span>
                    <span class="text-muted">Current month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Completed
                  </span>

                  <span>
                    <i class="fas fa-square text-danger"></i> Pending
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

      </div>
    </div>
    @endhasanyrole

    @hasanyrole('Coordinator|Admin')
    <div class="row">         
      <div class="col-md-12">
        <!-- AREA CHART -->
            <div class="card card-warning">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Team Sales</h3>
                  <a href="{{route('order.index')}}">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">AED 35,000.00</span>
                    <span>Sales Over The Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 
                    </span>
                    <span class="text-muted">Current month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart-team" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Completed
                  </span>

                  <span>
                    <i class="fas fa-square text-danger"></i> Pending
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

      </div>
    </div>
    @endhasanyrole
   
    <div class="row">
      <div class="col-lg-6 col-6">
        <div class="card card-success">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Your Monthly Goal</h3>             
            </div>
          </div>
        <div class="card-body">

        <div class="progress-group">
          Pending Orders
          <span class="float-right"><b><?=$target['pending']?></b>/<?=$target['goal']?></span>
          <div class="progress progress-sm">
            <div class="progress-bar bg-danger" style="width: <?=$target['pending_per']?>%"></div>
          </div>
        </div>
        <!-- /.progress-group -->

        <div class="progress-group">
          Completed Orders
          <span class="float-right"><b><?=$target['completed']?></b>/<?=$target['goal']?></span>
          <div class="progress progress-sm">
            <div class="progress-bar bg-success" style="width: <?=$target['completed_per']?>%"></div>
          </div>
        </div>

        </div>
      </div>

      </div>
      <div class="col-lg-6 col-6">
        
        <!-- /.card -->
      </div>
    </div>
    
  </div>
<!-- /.content -->
</section>

<script type="text/javascript">
$(document).ready(function(){ 

  // AGENT GRAPH
  var agentGraph = function(agdata){

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode      = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')

    var labels = [], dataset1 = [], dataset2 = [];

    $.each(agdata, function(index, items){
        labels.push(items['agent'])
        dataset1.push(items['completed'])
        dataset2.push(items['pending'])
    })


    var salesChart  = new Chart($salesChart, {
      type   : 'bar',
      data   : {
        labels  : labels,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor    : '#007bff',
            data           : dataset1
          },
          {
            backgroundColor: '#CD5C5C',
            borderColor    : '#CD5C5C',
            data           : dataset2
          }
        ]
      },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,
            min: 0,
            max: 22000,
            stepSize: 2000,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return  value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  });
  }; 

  // TEAM GRAPH
  var teamGraph = function(agdata){

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode      = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart-team')

    var labels = [], dataset1 = [], dataset2 = [];

    $.each(agdata, function(index, items){
        labels.push(items['team'])
        dataset1.push(items['completed'])
        dataset2.push(items['pending'])
    })


    var salesChart  = new Chart($salesChart, {
      type   : 'bar',
      data   : {
        labels  : labels,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor    : '#007bff',
            data           : dataset1
          },
          {
            backgroundColor: '#CD5C5C',
            borderColor    : '#CD5C5C',
            data           : dataset2
          }
        ]
      },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,
            min: 0,
            max: 35000,
            stepSize: 5000,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return  value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  });
  }; 

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      url:"{{ route('agentdata') }}",
      method:"GET",
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,  
      success:function(data){
        if(data.success){
         
          let agent = JSON.parse(data.agentdata); 
          agentGraph(agent);

          let team = JSON.parse(data.teamdata); 
          teamGraph(team);

        }

      }
  });


});    
</script>

@endsection