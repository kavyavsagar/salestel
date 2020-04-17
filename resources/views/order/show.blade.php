@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
          <li class="breadcrumb-item active">View Order</li>
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
                   Order Details
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
                <a class="nav-link active" id="nav-history-tab" data-toggle="pill" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="true">Order History</a>
                </li>              
                <li class="nav-item">
                <a class="nav-link" id="nav-plan-tab" data-toggle="pill" href="#nav-plan" role="tab" aria-controls="nav-plan" aria-selected="false">{{ ucfirst($order->plan_type) }} Plans</a>
                </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content" id="nav-tabContent">  
              <div class="tab-pane fade  show active" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                <div class="row">
                    <div class="col">&nbsp;</div>
                </div>
                <div class="table-responsive p-0">
                <table class="table table-striped table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th scope="col">Status</th>
                      <th scope="col">Comments</th>
                      <th scope="col">Activity No.</th>
                      <th scope="col">Added By</th>
                      <th scope="col">Date Added</th>
                    </tr>
                    </thead>
                    <tbody>  
                    @foreach ($ord_history as $key => $hist)
                    <tr>
                        <th scope="row">{{ucwords(str_replace("_"," ",$hist->name))}} </th>
                        <td>{{$hist->comments}}</td>
                        <td>{{$hist->activity_no}}
                          @if($order->activation_date && $hist->name == 'activation_complete')
                            <span title="Activated on"><i class="fas fa-toggle-on text-success"></i>&nbsp;{{$order->activation_date}}</span>
                          @endif
                        </td>
                        <td>{{$hist->fullname}}</td>
                        <td>{{date("d/m/Y", strtotime($hist->created_at))}}</td>
                    </tr>
                    @endforeach                    
                    </tbody>
                </table> 
                </div>
                @hasanyrole('Coordinator|Admin')
                <div class="row">
                    <div class="col">
                        <strong class="text-uppercase">Change Order Status</strong>
                        <hr/>
                    </div>
                </div>   
                {!! Form::open(array('route' => 'order.changestatus','method'=>'POST' )) !!} 
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                        <select class="form-control" name="order_status" id="ostatus">                 
                            @foreach ($ordstatus as $key => $value) 
                            <option value="{{ $key }}-{{ $value }}" {{ ( $key == $order->order_status_id ) ? 'selected' : '' }}> 
                                {{ ucwords(str_replace("_"," ",$value)) }} 

                            </option>
                            @endforeach    
                        </select>          
                        </div>    
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">

                        <div class="form-group {{ ($order->order_status_id == 13)? 'd-none' : ''}}" id="actno">
                            <input type="text" name="activity_no" placeholder ="Enter activity number" class="form-control"/>
                        </div>


                        <!-- Date dd/mm/yyyy -->
                        <div class="form-group {{ ($order->order_status_id == 13)?'':  'd-none'}}" id="actda">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="activation_date" id="datemask">
                          </div>
                          <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-4">
                        <div class="form-group">
                        <textarea name="comments" id="comments" class="form-control" placeholder="Enter comments"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-2">
                        <input type="hidden" name="orderid" value="{{$order->id}}">
                        <button type="submit" class="btn btn-primary btn-submit float-right">Add History</button>
                    </div>
              </div>
              {!! Form::close() !!}
              @endhasanyrole
            </div>
            <div class="tab-pane fade" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                <div class="row">
                    <div class="col">&nbsp;</div>
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
            <a class="btn btn-default float-right" href="{{ route('order.index') }}"> Cancel</a>
        </div>
        <!-- .card -->
        </div>
        <!-- .col -->
    </div>     
  </div>
</section>    
<script type="text/javascript">    
$(document).ready(function(){

  // Status
  $('#ostatus').on('change', function(e){
      let str = $(this).val(),
          d = $('#actda'),
          n = $('#actno');

      let status = str.split("-")[1]; 

      if(status == 'activation_complete')
      {
        if(d.hasClass("d-none")){
          d.removeClass('d-none');  
        }
        
        n.addClass('d-none');
      }else{
        if(n.hasClass("d-none")){
          n.removeClass('d-none');  
        }

        d.addClass('d-none');
      }
  });

}); 

</script>

@endsection