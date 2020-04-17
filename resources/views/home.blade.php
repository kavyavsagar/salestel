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
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$neworders}}</h3>

            <p>New Orders</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route('order.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$comporders['total']}} <sup style="font-size: 20px">AED</sup> | {{$comporders['count']}}</h3>
            <p>Total Revenue</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ route('order.complete') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
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
      <div class="col-lg-3 col-6">
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
    <div class="row">         
      <div class="col-md-12">
        <!-- AREA CHART -->
    <!--     <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Sales Report</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div> -->
          <!-- /.card-body -->
       <!--  </div> -->
        <!-- /.card -->
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-6">
          <!-- DONUT CHART -->
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Orders Progress</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">
              <input type="hidden" id="newordst" value="{{$neworders}}">
              <input type="hidden" id="leadsordst" value="{{$leads}}">
              <input type="hidden" id="duordst" value="{{$duapprove}}">
              <input type="hidden" id="createordst" value="{{$createdords}}">
              <input type="hidden" id="deliveryordst" value="{{$deliveryords}}">
              <input type="hidden" id="compordst" value="{{$comporders['count']}}">

              <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </div>
      <div class="col-lg-6 col-6">
        <!-- PIE CHART -->
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Orders Failed</h3>
              <input type="hidden" id="docordst" value="{{$docRejected}}">
              <input type="hidden" id="markordst" value="{{$markRejected}}">
              <input type="hidden" id="durejordst" value="{{$duRejected}}">
              <input type="hidden" id="rejordst" value="{{$rejectedords}}">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
<!-- /.content -->
</section>

<script type="text/javascript">
$(document).ready(function(){  

      let op = parseInt($('#newordst').val()),
        ld = parseInt($('#leadsordst').val()),
        du = parseInt($('#duordst').val()),
        ct = parseInt($('#createordst').val()),
        dv = parseInt($('#deliveryordst').val()),
        at = parseInt($('#compordst').val());
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Open', 
          'Lead Created',
          'Du Approved', 
          'Order Created', 
          'Item Delivered', 
          'Activation', 
      ],
      datasets: [
        {
          data: [op,ld,du,ct,dv,at],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })
    /****************************************************************************/
    let doc = parseInt($('#docordst').val())? parseInt($('#docordst').val()): 2,
        mf = parseInt($('#markordst').val())? parseInt($('#markordst').val()): 1,
        dr = parseInt($('#durejordst').val())?parseInt($('#durejordst').val()): 5,
        rj = parseInt($('#rejordst').val())? parseInt($('#rejordst').val()):7 ;
    //-------------
    //- PIE CHART -
    //-------------
    var pieData  = {
      labels: [
          'Document Rejected', 
          'Marketing Failed',
          'Du Rejected', 
          'Order Rejected',
      ],
      datasets: [
        {
          data: [doc,mf,dr,rj],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
        }
      ]
    }
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = pieData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    /**********************************************************************************/
    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    // var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    // var areaChartData = {
    //   labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //   datasets: [
    //     {
    //       label               : 'Digital Goods',
    //       backgroundColor     : 'rgba(60,141,188,0.9)',
    //       borderColor         : 'rgba(60,141,188,0.8)',
    //       pointRadius          : false,
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [28, 48, 40, 19, 86, 27, 90, 99]
    //     },
    //   ]
    // }

    // var areaChartOptions = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: false
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }]
    //   }
    // }

    // // This will get the first returned node in the jQuery collection.
    // var areaChart  = new Chart(areaChartCanvas, { 
    //   type: 'line',
    //   data: areaChartData, 
    //   options: areaChartOptions
    // })

});    
</script>

@endsection