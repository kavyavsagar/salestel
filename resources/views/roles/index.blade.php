@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Permissions</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Permissions</li>
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
          <h3 class="card-title">Manage Roles and Permissions</h3>
          @can('role-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('roles.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="roles-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Role</th>
              <th>Action</th>                 
            </tr>
            </thead>
            <tbody> 
              @foreach ($roles as $key => $role)
              <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>               
                <td>
                  @can('role-edit')
                    <a class="btn" href="{{ route('roles.edit',$role->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan
                  @can('role-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                        <button type="submit" class="btn" title="Delete"><i class="fas fa-trash"></i></button>
                    {!! Form::close() !!}
                  @endcan
                </td>
              </tr>
             @endforeach 
            </tbody>
            <tfoot>
            <tr>
              <th>#</th>
              <th>Role</th>
              <th>Action</th>                  
            </tr>
            </tfoot>
          </table>
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