@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View DSR</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dsr.index') }}">DSR</a></li>
          <li class="breadcrumb-item active">View DSR</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                   DSR Details
                </h3>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">#{{ $order->id }} - {{ ucfirst($order->plan_type) }}</li>
                <li class="list-group-item">{{ $order->total_amount }} AED</li>            
                <li class="list-group-item">
                  <span title="Created on"><i class="fas fa-calendar-plus"></i>&nbsp;{{ date("d/m/Y", strtotime($order->created_at)) }}</span>
                  @if($order->activation_date)
                    <span class="float-right" title="Activated on"><i class="fas fa-toggle-on text-success"></i>&nbsp;{{$order->activation_date}}</span>
                  @endif
                </li>

              </ul>         
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                   Customer Details
                </h3>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">{{ $order->company_name }}<span class="ml-2 text-info">({{ $order->account_no }})</span></li>
                <li class="list-group-item">{{ $order->location }}</li>            
                <li class="list-group-item">{{ $order->fullname }}</li>
              </ul>         
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                  Authority Details
                </h3>
              </div>
              <ul class="list-group list-group-flush">            
                <li class="list-group-item">{{ $order->authority_name }}</li>
                <li class="list-group-item">{{ $order->authority_email }}</li>
                <li class="list-group-item">{{ $order->authority_phone }}</li>
              </ul>          
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="card">            
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                   Technical Person Details
                </h3>
              </div>        
               <ul class="list-group list-group-flush">      
                <li class="list-group-item">{{ $order->technical_name }}</li>
                <li class="list-group-item">{{ $order->technical_email }}</li>
                <li class="list-group-item">{{ $order->technical_phone }}</li>            
              </ul>
            </div>
        </div>
    </div>      
    <div class="row">
        <div class="col"><br/></div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card">            
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-file-upload"></i>
                   Documents
                </h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                @foreach ($documents as $key => $doc)
                    <div id="{{$key}}" class="d-inline"> 
                       <img src="{{asset($doc)}}" class="img-fluid img-thumbnail m-1 mht-100">
                    </div>
                @endforeach 
                </div>                  
              </div>                      
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col"><br/></div>
    </div> 
    <div class="row">
        <div class="col">
        <!-- general form elements -->
        <div class="card card-primary card-outline card-outline-tabs">     
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">                            
                <li class="nav-item">
                  <a class="nav-link active" id="nav-plan-tab" data-toggle="pill" href="#nav-plan" role="tab" aria-controls="nav-plan" aria-selected="false">{{ ucfirst($order->plan_type) }} Plans</a>
                </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content" id="nav-tabContent">  
        
            <div class="tab-pane fade show active" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                
                <div class="row">
                    <div class="col">
                      <dl class="row">
                        <dt class="col-sm-4">Expected Revenue</dt>
                        <dd class="col-sm-8">AED {{$order->exp_revenue}}</dd>
                        <dt class="col-sm-4">Expected Closing Date</dt>
                        <dd class="col-sm-8">{{$order->exp_closing_date}}</dd> 
                        <dt class="col-sm-4">Sales Priority</dt>
                        <dd class="col-sm-8">
                        @switch($order->sales_priority)
                          @case('hot')
                              <span class="text-danger">{{ ucfirst($order->sales_priority) }}</span>
                              @break
                          @case('warm')
                              <span class="text-success">{{ ucfirst($order->sales_priority) }}</span>
                              @break
                          @default
                              <span class="text-info">{{ ucfirst($order->sales_priority) }}</span>
                          @endswitch
                        </dd> 
                        <!-- <dt class="col-sm-4">Activate To Order</dt>
                        <dd class="col-sm-8"><input type="checkbox" name="activate_ord" data-bootstrap-switch data-off-color="danger" data-on-color="success" id="ostatus"></dd>  -->
                      </dl>
                    </div>
                </div>
                <div class="table-responsive p-0">
                <table class="table table-striped table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th scope="col">MRC</th>
                      <th scope="col">PLAN</th>
                      <th scope="col">TYPE</th>
                      <th scope="col">QTY</th>
                      <th scope="col">TOTAL (AED)</th>
                    </tr>
                    </thead>
                    <tbody>  
                    @foreach ($ord_plans as $key => $plan)
                    <tr>
                        <th scope="row">{{$plan->price}}</th>
                        <td>{{$plan->plan}}</td>
                        <td>{{$plan->plan_type}}</td>
                        <td>{{$plan->quantity}}</td>
                        <td>{{$plan->total}}</td>
                    </tr>
                    @endforeach    
                    <tr>
                        <th scope="row"></th>
                        <td colspan="3" align="right"><b>SubTotal :</b></td>
                        <td align="left">{{$order->total_amount}}</td>
                    </tr>                   
                    </tbody>
                </table>
                </div>
              </div>
            <div class="row">
                <div class="col"><br/></div>
            </div>
          </div>
          <!-- /.card-body -->         
        </div>
        <div class="card-footer">
            <a class="btn btn-default float-right" href="{{ route('dsr.index') }}"> Cancel</a>
        </div>
        <!-- .card -->
        </div>
        <!-- .col -->
    </div>     
  </div>
</section>    


@endsection