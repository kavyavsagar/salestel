@extends('layouts.app')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Host a Meeting</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Host a meeting</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- /.container-fluid -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-lg-3"></div>
      <div class="col-lg-6">
        {!! Form::open(array('route' => 'meeting.host','method'=>'POST')) !!}
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title m-0">Meeting Room</h5>
          </div>
          <div class="card-body">           
            <p class="card-text">You can share the room name and page link with the customer to join your meeting room.</p>
            <dl class="row">
              <dt class="col-sm-3">Room Name</dt>
              <dd class="col-sm-9">{{ $data['roomid'] }}</dd>
              <dt class="col-sm-3">Share Link</dt>
              <dd class="col-sm-9">https://tsm.emperorcom.ae/joinmeeting</dd>
            </dl>
            <p class="card-text"><i class="fas fa-info mr-2 text-info"></i> Once you hosted a meeting, you can set your profile name.</p>
            <input type="hidden" name="room" value="{{ $data['roomid'] }}">
            <button type="submit" class="btn btn-primary">Start Meeting</a>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="col-lg-3"></div>
  
    </div>
  </div>
</section>

@endsection
