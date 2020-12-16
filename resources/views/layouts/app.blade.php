<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Telecom User And Sales Management') }}</title>
    <!-- Favicon -->   
  <link rel="apple-touch-startup-image" href="{{ asset('image/logo/apple-touch-icon.png') }}">
  <link href="{{ asset('image/logo/iphone5_splash.png') }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/iphone6_splash.png') }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/iphoneplus_splash.png') }}" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/iphonex_splash.png') }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/iphonexr_splash.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/iphonexsmax_splash.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/ipad_splash.png') }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/ipadpro1_splash.png') }}" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/ipadpro3_splash.png') }}" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link href="{{ asset('image/logo/ipadpro2_splash.png') }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/logo/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo/favicon-16x16.png') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('image/logo/favicon.ico') }}" />
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <link rel="mask-icon" href="{{ asset('image/logo/safari-pinned-tab.svg') }}" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#87ceeb">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes"> 
  <meta name="apple-touch-fullscreen" content="yes" />
  <meta name="apple-mobile-web-app-title" content="TSM" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />   
  <meta name="msapplication-starturl" content="/">
  <meta name="theme-color" content="#ffffff">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!--  Custom Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">      
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</head>
<body class="sidebar-mini">
  <div class="wrapper">
    <!-- .navbar -->
    @include('inc.nav')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('inc.sidebar')
    <!-- /.Main Sidebar Container -->
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>{{ Auth::user()->fullname }}</h5>
            <p class="ts-menu-item">
                <a href="{{ route('users.edit',  Auth::id()) }}"><i class="fas fa-user-circle"></i>Account Settings</a></p>
            <p class="ts-menu-item d-none" id="installContainer" >
                <a id="btnInstall" href="#"><i class="fas fa-download"></i>Install App</a>
            </p>
            <p class="ts-menu-item">
               <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}</a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer d-none d-sm-block">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Telecom Sales Management System
        </div>
        <!-- Default to the left -->
        Copyright &copy; 2020 <strong><a href="https://www.emperorcom.ae/">Emperorcom Technologies</a>.</strong> All rights reserved.
    </footer>
  </div>

    <script type="text/javascript">
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function() {
        navigator.serviceWorker.register('{{ asset("sw.js") }}').then(function(registration) {
          // Registration was successful
          console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
          // registration failed :(
          console.log('ServiceWorker registration failed: ', err);
        });
      });
    }
    $(document).ready(function() {
      var todo = <?=$todo['task']?>;
     
      if(todo.length> 0){
        let astr ='<ul>';
        $.each(todo, function(index, item){
          astr += '<li>'+item['description']+'</li>';
        });
        astr +='</ul>'
         
        $(document).Toasts('create', {
          title: 'Todo - Today',
          position: 'bottomRight',
          class: 'bg-info', 
          body: astr
        })
      }
      /************************************/
      var dsr = <?=$todo['dsr']?>;
     
      if(dsr.length> 0){
        let dsr_str ='<ul>';
        $.each(dsr, function(index, item){
          let now = new moment(item['reminder_date']);

          dsr_str += '<li>'+item['company']+' | '+item['phone']+' | <b>'+now.format("hh:mm A")+'</b></li>';
        });
        dsr_str +='</ul>'
         
        $(document).Toasts('create', {
          title: 'DSR Reminder',
          // position: 'bottomLeft',
          class: 'bg-warning', 
          body: dsr_str
        })
      }
      
    });

    </script>  
    
    <!-- REQUIRED SCRIPTS --> 
    <script src="{{ asset('js/pwa.js') }}"></script>  

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
    <!-- jQuery Ui -->
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>   
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>