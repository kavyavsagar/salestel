@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Show Order</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('order.index') }}"> Back</a>
        </div>
    </div>
</div>
  
<div class="row">
    <div class="col-xs-12 col-sm-3 col-md-3">
        <div class="card">
          <div class="card-header">
            Order Details
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">#{{ $order->id }} - {{ ucfirst($order->plan_type) }}</li>
            <li class="list-group-item">{{ $order->total_amount }} AED</li>            
            <li class="list-group-item">{{ date("d/m/Y", strtotime($order->created_at)) }}</li>
          </ul>         
        </div>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3">
        <div class="card">
          <div class="card-header">
            Customer Details
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">{{ $order->company_name }}</li>
            <li class="list-group-item">{{ $order->location }}</li>            
            <li class="list-group-item">{{ $order->fullname }}</li>
          </ul>         
        </div>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3">
        <div class="card">
          <div class="card-header">
            Authority Details
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
            Technical Person Details
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
    <div class="col-xs-12 col-sm-12 col-md-12"><br/></div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Documents:</strong><br/>
            @foreach ($documents as $key => $doc)
            <div id="{{$key}}" class="thumbimg">    
               <img src="{{url($doc)}}" class="thumb">
            </div>
            @endforeach 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12"><br/></div>
</div>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">    
    <a class="nav-item nav-link active" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">Order History</a>
    <a class="nav-item nav-link" id="nav-plan-tab" data-toggle="tab" href="#nav-plan" role="tab" aria-controls="nav-plan" aria-selected="true">{{ ucfirst($order->plan_type) }} Plans</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">  
  <div class="tab-pane fade  show active" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
          <th scope="col">Status</th>
          <th scope="col">Comments</th>
          <th scope="col">Activity No</th>
          <th scope="col">Added By</th>
          <th scope="col">Date Added</th>
        </tr>
        </thead>
        <tbody>  
        @foreach ($ord_history as $key => $hist)
        <tr>
            <th scope="row">{{ucwords(str_replace("_"," ",$hist->name))}} </th>
            <td>{{$hist->comments}}</td>
            <td>{{$hist->activity_no}}</td>
            <td>{{$hist->fullname}}</td>
            <td>{{date("d/m/Y", strtotime($hist->created_at))}}</td>
        </tr>
        @endforeach                    
        </tbody>
    </table> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
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
            <div class="form-group">
                <input type="text" name="activity_no" placeholder ="Enter activity number" class="form-control"/>
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
</div>
<div class="tab-pane fade" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
          <th scope="col">MRC</th>
          <th scope="col">PLAN</th>
          <th scope="col">QTY</th>
          <th scope="col">TOTAL (AED)</th>
        </tr>
        </thead>
        <tbody>  
        @foreach ($ord_plans as $key => $plan)
        <tr>
            <th scope="row">{{$plan->price}}</th>
            <td>{{$plan->plan}}</td>
            <td>{{$plan->quantity}}</td>
            <td>{{$plan->total}}</td>
        </tr>
        @endforeach    
        <tr>
            <th scope="row"></th>
            <td colspan="2" align="right"><b>SubTotal :</b></td>
            <td align="left">{{$order->total_amount}}</td>
        </tr>                   
        </tbody>
    </table>
  </div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12"><br/><br/></div>
</div>


@endsection
