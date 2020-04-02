@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Plan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">Plans</a></li>
          <li class="breadcrumb-item active">Edit Plan</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
     
      <div class="col">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Plan</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          {!! Form::model($plan, ['method' => 'PATCH','route' => ['plan.update', $plan->id]]) !!}
            <div class="card-body">
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
                <div class="form-group">
                    <label for="plan-name">Name</label>                   
                    {!! Form::text('plan', null, array('placeholder' => 'Plan Name','class' => 'form-control', 'id' => 'plan-name')) !!}
                </div>
                <div class="form-group">
                  <label for="plan-type">Plan Type</label>
                  <select class="form-control" name="plan_type" id="plan-type">   
                    <option value="0">-- Select --</option>                
                    @foreach ($plantype as $value)
                       <option value="{{ $value }}" {{ ( $value == $plan->plan_type) ? 'selected' : '' }}> 
                    {{ ucwords($value) }} 
                </option>
                    @endforeach    
                  </select>
              </div> 
             
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-default float-right" href="{{ route('plan.index') }}"> Cancel</a>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>

@endsection