@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
          <li class="breadcrumb-item active">Edit User</li>
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
            <h3 class="card-title">Edit User Profile</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->          
            {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
            <div class="card-body">
                @if ($message = Session::get('success'))
                  <div class="alert alert-success">
                      <p>{{ $message }}</p>
                  </div>
                @endif
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
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Mobile No:</label>
                        {!! Form::text('phone', null, array('placeholder' => 'Mobile No','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Title:</label>
                        {!! Form::text('title', null, array('placeholder' => 'Designation','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Assign Team Lead:</label>                   
                        
                        <select class="form-control" name="parentid" @if(!Gate::check('user-create')) disabled @endif>   
                          <option value="0">-- Select --</option>                
                          @foreach ($parents as $key => $value)
                            <option value="{{ $key }}" {{ ( $key == $user->parentid) ? 'selected' : '' }}> 
                                {{ $value }} 
                            </option>
                          @endforeach    
                        </select>
                    
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Role:</label>
                        <select class="form-control" name="roles" @if(!Gate::check('user-create')) disabled @endif>   
                          <option value="0">-- Select --</option>                
                          @foreach ($roles as $key => $value)
                            <option value="{{ $key }}" {{ ( $key == isset($userRole[$key])) ? 'selected' : '' }}> 
                                {{ $value }} 
                            </option>
                          @endforeach    
                        </select>

                       <!--  @can('user-create')
                        {!! Form::select('roles[]', $roles, $userRole, array('class' => 'form-control','multiple')) !!}
                        @endcan  -->
                    </div>
                </div>
            </div>
           </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              @can('user-list')
              <a class="btn btn-default float-right" href="{{ route('users.index') }}"> Cancel</a>
              @endcan 
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>


@endsection