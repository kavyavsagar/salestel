@extends('layouts.meeting')

@section('content')

<!-- /.container-fluid -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->   
    <div class="col">
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://meet.emperorcom.ae/{{$data['meetid']}}" allow="camera;microphone;"></iframe>
      </div>
    </div>  
    </div>
  </div>
</section>

@endsection
