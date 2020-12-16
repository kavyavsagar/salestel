@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Create User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
          <li class="breadcrumb-item active">Create User</li>
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
            <h3 class="card-title">New User</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
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
            <div class="row">           
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        {!! Form::text('fullname', null, array('placeholder' => 'Name','class' => 'form-control', 'id' => 'fullname')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Email:</label>
                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Password:</label>
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Confirm Password:</label>
                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Mobile No:</label>
                        {!! Form::text('phone', null, array('placeholder' => 'Mobile No','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Title:</label>
                        {!! Form::text('title', null, array('placeholder' => 'Designation','class' => 'form-control')) !!}
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Goal:</label>
                        {!! Form::text('goal', null, array('placeholder' => 'Monthly Target','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Assign Team Lead:</label>
                        <select class="form-control" name="parentid">   
                          <option value="0">-- Select --</option>                
                          @foreach ($parents as $key => $value)
                            <option value="{{ $key }}"> 
                                {{ $value }} 
                            </option>
                          @endforeach    
                        </select>
                       <!--  {!! Form::select('parentid', $parents, null, array('class' => 'form-control')) !!} -->
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Role:</label>
                        <select class="form-control" name="roles">   
                          <option value="">-- Select --</option>                
                          @foreach ($roles as $key => $value)
                            <option value="{{ $key }}"> 
                                {{ $value }} 
                            </option>
                          @endforeach    
                        </select>
                        <!-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} -->
                    </div>
                </div>
            </div>
           </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-default float-right" href="{{ route('users.index') }}"> Cancel</a>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>

@endsection