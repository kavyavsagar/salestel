@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Customer Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('customer.create') }}"> Create New Customer</a>
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
   <th>No</th>
   <th>Company</th>
   <th>Person</th>
   <th>Phone</th>
   <th>Reffered By</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $customer)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $customer->company_name }}</td>
    <td>{{ $customer->authority_name }}</td>
    <td>{{ $customer->authority_phone }}</td>
    <td>{{ $customer->fullname }}</td>
    <td>
       <a class="btn btn-info" href="{{ route('customer.show',$customer->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('customer.edit',$customer->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['customer.destroy', $customer->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}


@endsection