@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Orders</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col">

        <div class="card">
        <div class="card-header">
          <h3 class="card-title">Order Management</h3>
          @can('order-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('order.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="order-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
               <th>OrderId</th>
               <th>Customer</th>
               <th>Status</th>
               <th>Total</th>
               <th>Reffered By</th>
               <th>Created At</th>
               <th>Action</th>                     
            </tr>
            </thead>
            <tbody> 
             @foreach ($data as $key => $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->company_name }}</td>
                <td>{{ ucfirst(str_replace("_", " ", $order->status)) }}</td>
                <td>
                <span class="gray" title="{{ ucfirst($order->plan_type) }}"><i class="fas {{ ($order->plan_type == 'mobile') ? 'fa-mobile-alt' : 'fa-phone-alt' }}"></i></span>&nbsp; {{ $order->total_amount }} </td>
                <td>{{ $order->fullname }}</td>
                <td>{{ date("Y-m-d",strtotime($order->created_at)) }}</td>
                <td>
                   <a class="btn" href="{{  route('order.show',$order->id) }}" title="View Orders"><i class="fas fa-eye"></i></a>
                  @can('order-edit')
                   <a class="btn" href="{{ route('order.edit',$order->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan 
                  @can('customer-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['order.destroy', $order->id],'style'=>'display:inline']) !!}
                    <button type="submit" class="btn" title="Delete"><i class="fas fa-trash"></i></button>
                  {!! Form::close() !!}
                @endcan
                </td>
              </tr>
             @endforeach           
            </tbody>
            <tfoot>
            <tr>
               <th>OrderId</th>
               <th>Customer</th>
               <th>Status</th>
               <th>Total</th>
               <th>Reffered By</th>
               <th>Created At</th>
               <th>Action</th>             
            </tr>
            </tfoot>
          </table>
          <div class="float-right"> {!! $data->render() !!}</div>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- <div class="col">&nbsp;</div> -->
    </div>
  </div>
</section> 
<!-- /.content -->



@endsection