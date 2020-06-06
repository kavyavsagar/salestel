@extends('layouts.meeting')


@section('content')
<section class="content">
  <div class="container">
    <div class="row">
      <!-- left column -->   
    <div class="col">

      <!-- Automatic element centering -->
      <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
          <div class="login-logo">
             <a href="{{ url('/') }}"><b>JOIN</b> Meeting</a>
          </div>
        </div>
        <!-- User name -->
        <div class="lockscreen-name">Welcomes You</div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
          <!-- lockscreen image -->
          <div class="lockscreen-image">
            <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Image">
          </div>
          <!-- /.lockscreen-image -->

          <!-- lockscreen credentials (contains the form) -->
          {!! Form::open(array('route' => 'meeting.joined','method'=>'POST', 'class' => 'lockscreen-credentials')) !!}
           
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Meeting ID" name="meetid">
              <div class="input-group-append">
                <button type="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
              </div>
            </div>
            @if (count($errors) > 0)
            <div class="alert text-danger">      
                @foreach ($errors->all() as $error)
                <span class="small">{{ $error }}</span>
                @endforeach         
            </div>
            @endif
            @if ($message = Session::get('error'))
              <div class="alert text-danger">
                <span class="small">{{ $message }}</span>
              </div>
            @endif
          {!! Form::close() !!}
          <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
          Enter your meeting Id to join the session
        </div>
        @guest
        <div class="text-center">
          <a href="{{ route('login') }}">Or sign in as employee user</a>
        </div>
        <div id="installContainer" class="text-center">
          <p class="text-muted">Get our free app. It won't take up space on your phone.</p>
          <button class="btn btn-secondary" id="btnInstall" type="button"><i class="fas fa-download"></i>&nbsp;Install</button>
        </div> 
        @endauth      
      </div>
      <!-- /.center -->


    </div>
    </div>
  </div>
</section>   
@endsection