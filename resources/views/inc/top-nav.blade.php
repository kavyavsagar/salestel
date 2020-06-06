  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{asset('image/telephone.png')}}" alt="TSM Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text mr-2">TSM</span><small class="font-weight-light">Telecom Sales Management</small>
      </a>

      @auth
      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
        </li>
      </ul>
      @endauth
    </div>
  </nav>
  <!-- /.navbar -->