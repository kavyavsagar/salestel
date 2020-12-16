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
                <li class="list-group-item"> @if($order->order_status_id == 23) {{ $order->partial_amount }} / {{ $order->total_amount }} AED  @else {{ $order->total_amount }} AED @endif</li>            
                <li class="list-group-item">
                  @php
                    $time = strtotime($order->created_at) + 60*60*4;
                  @endphp   
                  <span title="Created on"><i class="fas fa-calendar-plus"></i>&nbsp;{{ date("d/m/Y H:i:s", $time) }}</span>
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
                @if(!count($documents))  
                  <div class="d-inline text-muted">No documents !!</div>
                @endif
                @foreach ($documents as $key => $doc)
                    <div id="{{$key}}" class="d-inline">                       
                    @php
                      $file_parts = pathinfo($doc);
                    @endphp

                    @if($file_parts['extension'] == 'pdf')
                      <a href="{{asset($doc)}}" download>{{ explode("/",$doc)[1] }}</a><br/>
                    @else
                      <a href="{{asset($doc)}}" download><img src="{{asset($doc)}}" class="img-fluid img-thumbnail m-1 mht-100"></a><br/>
                    @endif
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
                      <th scope="col">Activity</th>
                      <th scope="col">Added By</th>
                      <th scope="col">Date Added</th>
                    </tr>
                    </thead>
                    <tbody>  
                    @foreach ($ord_history as $key => $hist)
                      @php
                        $time = strtotime($hist->created_at) + 60*60*4;
                      @endphp
                    <tr>
                        <th scope="row">{{ucwords(str_replace("_"," ",$hist->name))}} </th>
                        <td>{{$hist->comments}}</td>
                        <td>                          
                          <dl class="row">
                            @if($hist->activity_no)
                            <dt class="col-sm-4">Activity No</dt>
                            <dd class="col-sm-8">{{$hist->activity_no}}</dd>
                            @endif 
                         <!--    @if($order->activation_date && ($hist->name == 'activation_complete' || $hist->name == 'partial_completed'))
                            <dt class="col-sm-4">Activation On</dt>
                            <dd class="col-sm-8"> <span title="Activated on"><i class="fas fa-toggle-on text-success"></i>&nbsp;{{$order->activation_date}}</span></dd>
                            @endif -->   
                            @if($hist->last_amount)                                      
                            <dt class="col-sm-4">Partial Amount</dt>
                            <dd class="col-sm-8">{{ $hist->last_amount }}</dd> 
                            @endif   
                            @if($hist->last_act_date && $hist->last_act_date != '0000-00-00' && $hist->last_act_date != null)        
                            <dt class="col-sm-4">Activation On</dt>
                            <dd class="col-sm-8">{{ $hist->last_act_date }}</dd> 
                            @endif       
                          </dl>
                         
                        </td>
                        <td>{{$hist->fullname}}</td>
                        <td>{{ date("Y-m-d H:i:s", $time) }}</td>
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
                {!! Form::open(array('route' => 'order.changestatus','method'=>'POST', 'id' =>'statusfrm' )) !!} 
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

                        <div class="form-group {{ (in_array($order->order_status_id, [13, 23]))? 'd-none' : ''}}" id="actno">
                            <input type="text" name="activity_no" placeholder ="Enter activity number" class="form-control"/>
                        </div>

                        <div class="form-group {{ (in_array($order->order_status_id, [13, 23]))?'':  'd-none'}}" id="actda">
                          <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="activation_date"/>
                             
                              <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                              </div>
                          </div>
                        </div>
                        <div class="form-group {{ (in_array($order->order_status_id, [13, 23]))?'':  'd-none'}}" id="partamt">
                          <input type="text" name="partial_amount" placeholder ="Enter partial amount" class="form-control"/>
                        </div>
                        <!-- Date dd/mm/yyyy -->
                       <!--  <div class="form-group {{ ($order->order_status_id == 13)?'':  'd-none'}}" id="actda">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="activation_date" id="datemask">
                          </div>
                       
                        </div> -->
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
              <input type="hidden" id="acc_no" value="{{ $order->account_no }}">
              <input type="hidden" id="acc_dt" value="{{ $order->activation_date }}">   
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
                      @if($order->plan_type == 'mobile')
                      <th scope="col">PHONENO.</th>
                      @endif
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
                        @if($order->plan_type == 'mobile')
                        <td><span id="ph_{{$plan->id}}">{{$plan->phoneno}} </span>

                          <input type="hidden" value="{{$plan->phoneno}}" id="phoneno">
                          <a href="javascript:void(0);" class="editph ml-2 mt-1" id="editph_{{$plan->id}}" rel="{{$plan->id}}">Edit</a>
                          <div id="view_{{$plan->id}}" class="d-none form-group">
                            <textarea class="form-control" col="4" name="phoneno_{{$plan->id}}" id="phoneno_{{$plan->id}}">{{$plan->phoneno}}</textarea>
                            <button type="button" class="btn btn-primary mt-1 save-btn" id="btn_{{$plan->id}}">Save</button>
                          </div>
                          
                        </td> 
                        @endif                       
                        <td>{{$plan->quantity}}</td>
                        <td>{{$plan->total}}</td>
                    </tr>
                    @endforeach    
                    <tr>
                        <th scope="row"></th>
                        <td colspan="4" align="right"><b>SubTotal :</b></td>
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
            <a class="btn btn-secondary float-right" href="{{ route('order.index') }}"> Cancel</a>
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
          at = $('#partamt'),
          n = $('#actno');

      let status = str.split("-")[1]; 

      if(status == 'activation_complete'){

        if(d.hasClass("d-none")){
          d.removeClass('d-none');  
        }
        
        at.addClass('d-none');
        n.addClass('d-none');

      }else if(status == 'partial_completed'){

        if(d.hasClass("d-none")){
          d.removeClass('d-none');  
        }
        if(at.hasClass("d-none")){
          at.removeClass('d-none');  
        }
        
        n.addClass('d-none');
      }else{
        if(n.hasClass("d-none")){
          n.removeClass('d-none');  
        }

        at.addClass('d-none');
        d.addClass('d-none');
      }
  });

  $('#statusfrm').submit(function(e){

      let str = $('#ostatus').val(),
         ast = str.split('-'),
         st = parseInt(ast[0]);

      if(st == 13 || st == 23){ // completed & partial completed
        let accno = $('#acc_no').val(),
            actdate = $('#acc_dt').val(),
            curdate =  $("input[name*='activation_date']").val(),
            phone = $('#phoneno').val(),
            part_amt = $("input[name*='partial_amount']").val();

        if(accno.trim() == '' || accno.trim() == null){
           alert('Account no is missing');
           return false;
        }

        if((actdate.trim() == '' || actdate.trim() == null || actdate.trim() == '1970-01-01') && !curdate){
           alert('Activation date is missing');
           return false;
        }

        if(st == 23 && (part_amt == '' || part_amt == 0)){
          alert('Partial Amount is missing');
          return false;
        }

        if(phone.trim() == '' || phone.trim() == null){
           alert('Phone numbers are missing');
           return false;
        }
      }
  });

  $('#datetimepicker1').datetimepicker({
     format: 'YYYY-MM-DD'
  });

  $('.editph').on('click', function(e){
      let pid = $(this).attr('rel'),
          vw = $('#view_'+pid);
      
      if(vw.hasClass("d-none")){
      
        vw.removeClass("d-none");
        $(this).text('Cancel');
      }else{        
         vw.addClass("d-none");
         $(this).text('Edit');
      }
  });

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $('.save-btn').on('click', function(e){
    
    let str = $(this).attr('id');
        str = str.split("_");
    
    let pid = parseInt(str[1]),
        phonenos = $("#phoneno_"+pid).val();

    if(phonenos == '' || !phonenos){
      alert('Please enter phone numbers')
      return false;
    }
    /***********************************************/


    $.ajax({
        method:'POST',
        url:"{{ route('order.updatephone') }}",
        data: {phone: phonenos, planid: pid},              
        success:function(data){
         if(data == 'success'){
          $('#view_'+pid).addClass("d-none");
          $('#ph_'+pid).text(phonenos);
          
          $('#editph_'+pid).text('Edit');
         }
          
        },
        error:function(data){  

            console.log(data.responseJSON.errors)
            
        }
    });


  });

}); 

</script>

@endsection