@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Users</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
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
          <h3 class="card-title">Users Management</h3>
          @can('user-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('users.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="users-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
             <th>#</th>
             <th>Name</th>
             <th>Email</th>
             <th>Roles</th>
             <th>Action</th>                
            </tr>
            </thead>
            <tbody> 
            @foreach ($data as $key => $user)             
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->fullname }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @if(!empty($user->getRoleNames()))
                  @foreach($user->getRoleNames() as $v)
                     <label class="badge bg-success">{{ $v }}</label>
                  @endforeach
                @endif
              </td>
              <td>    
                <a class="btn" href="{{ route('users.show',$user->id) }}" title="View User"><i class="fas fa-eye"></i></a>
                @can('user-edit')
                  <a class="btn" href="{{ route('users.edit',$user->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                @endcan                 
                @can('user-delete')
                   {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
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
             <th>Name</th>
             <th>Email</th>
             <th>Roles</th>
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