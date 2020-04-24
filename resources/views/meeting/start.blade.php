@extends('layouts.app')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Start Meeting</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Meeting Room</li>
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
     
      <div class="col">
        <!-- general form elements -->
        <div class="card card-primary">
         <!--  <div class="card-header">
            <h3 class="card-title">Start Meeting</h3>            
          </div> -->
          <!-- /.card-header -->
          <!-- form start -->         
            <div class="card-body">

              <div id="meet"><h1>Coming Soon..</h1></div>

              <input type="hidden" value="{{$data['meetingid']}}" id="mid">
              <input type="hidden" value="{{$data['fullname']}}" id="fname">
              <input type="hidden" value="{{$data['email']}}" id="uemail"> 
            </div>
            <!-- /.card-body -->
            <div class="card-footer">              
              <a href="{{ route('meeting.index') }}" class="btn btn-primary" >Back</a>
            </div>
    
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>


<!-- <script src="https://meet.jit.si/external_api.js"></script> -->
<script type="text/javascript">  
   
    // var meet =  document.querySelector('#meet'),
    //     roomid = document.getElementById('mid').value,
    //     fname = document.getElementById('fname').value,
    //     uemail = document.getElementById('uemail').value;

    // meet.innerHTML = '';
    
    // var domain = "meet.jit.si";
    // var options = {
    //     roomName: 'Babu-1587383231018',            
    //     parentNode: meet,
    //     width: '100%',
    //     height: '30em',
    //     configOverwrite: {
    //         disableDeepLinking: true,            
    //     },
    //     interfaceConfigOverwrite: {
    //       //filmStripOnly: true,
    //       DEFAULT_REMOTE_DISPLAY_NAME: 'You',
    //       SHOW_JITSI_WATERMARK: false,
    //       JITSI_WATERMARK_LINK: '',
    //       // if watermark is disabled by default, it can be shown only for guests
    //       SHOW_WATERMARK_FOR_GUESTS: false,
    //       SHOW_BRAND_WATERMARK: false,
    //       BRAND_WATERMARK_LINK: '',
    //       APP_NAME: 'TSM Meet',
    //       NATIVE_APP_NAME: 'TSM Meet',
    //       PROVIDER_NAME: 'TSM',
    //     },
    //     userInfo: {
    //       email: uemail,
    //       displayName: fname
    //   }
    // }
    // var api = new JitsiMeetExternalAPI(domain, options);  
</script>
@endsection
