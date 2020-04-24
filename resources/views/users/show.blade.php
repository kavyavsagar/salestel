@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
          <li class="breadcrumb-item active">View User</li>
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              User Details
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-4">Full Name</dt>
              <dd class="col-sm-8">{{ $user->fullname }}</dd>
              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8">{{ $user->email }}</dd>
              <dt class="col-sm-4">Mobile No:</dt>
              <dd class="col-sm-8">{{ $user->phone }}</dd>
              <dt class="col-sm-4">Title</dt>
              <dd class="col-sm-8"> {{ $user->title }}</dd>
              <dt class="col-sm-4">Team Leader</dt>
              <dd class="col-sm-8">{{ !$user->parentid ? '--': $parent->fullname }}</dd>
              <dt class="col-sm-4">Roles</dt>
              <dd class="col-sm-8">
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif
              </dd>
            </dl>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
                <a class="btn btn-default float-right" href="{{ route('users.index') }}"> Cancel</a>
          </div>
        </div>

      </div>
      </div>

    </div>
</section>


@endsection