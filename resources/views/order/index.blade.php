@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Orders</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('order.create') }}"> Create New Order</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>OrderId</th>
   <th>Customer</th>
   <th>Status</th>
   <th>Total</th>
   <th>Reffered By</th>
   <th>Created At</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $order)
  <tr>
    <td>{{ $order->id }}</td>
    <td>{{ $order->company_name }}</td>
    <td>{{ ucfirst(str_replace("_", " ", $order->status)) }}</td>
    <td>{{ $order->total_amount }} <small class="gray">[{{ ucfirst($order->plan_type) }}]</small></td>
    <td>{{ $order->fullname }}</td>
    <td>{{ date("Y-m-d",strtotime($order->created_at)) }}</td>
    <td>
       <a class="btn btn-info" href="{{ route('order.show',$order->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['order.destroy', $order->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}


@endsection