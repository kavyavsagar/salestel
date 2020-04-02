@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Permission</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Permissions</a></li>
          <li class="breadcrumb-item active">Edit Permission</li>
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
            <h3 class="card-title">New Role and Permissions</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
            {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
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
                    <label for="role-name">Name</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'id' => 'role-name')) !!}
                </div> 
                <div class="form-group">
                    <label for="permission">Permissions</label>
                    @foreach($permission as $value)
                        <div class="form-check">
                          {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'form-check-input', 'id' => $value->id )) }}
                          <label class="form-check-label" for="{{ $value->id}}">{{ $value->name }}</label>
                        </div>   
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-default float-right" href="{{ route('roles.index') }}"> Cancel</a>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>

@endsection