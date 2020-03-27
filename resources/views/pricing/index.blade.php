@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Manage Pricing</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('pricing.create') }}"> Create New Pricing</a>
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
   <th>Amount</th>
   <th>Plan Type</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($pricings as $key => $price)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $price->amount }}</td>
    <td>{{ ucwords($price->plan_type) }}</td>
    <td>
      <!--  <a class="btn btn-info" href="{{ route('pricing.show',$price->id) }}">Show</a> -->
       <a class="btn btn-primary" href="{{ route('pricing.edit',$price->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['pricing.destroy', $price->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $pricings->render() !!}


@endsection