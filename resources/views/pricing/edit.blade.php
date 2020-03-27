@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Price</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('pricing.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif


{!! Form::model($pricing, ['method' => 'PATCH','route' => ['pricing.update', $pricing->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Amount:</strong>
            {!! Form::text('amount', null, array('placeholder' => 'Amount','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Plan Type:</strong>
            <select class="form-control" name="plan_type">   
              <option value="0">-- Select --</option>                
              @foreach ($plantype as $value)
                <option value="{{ $value }}" {{ ( $value == $pricing->plan_type) ? 'selected' : '' }}> 
                    {{ ucwords($value) }} 
                </option>
              @endforeach    
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}

@endsection