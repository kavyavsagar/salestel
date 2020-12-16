  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link" title="Telecom Sales Management">
      <img src="{{asset('image/telephone.png')}}" alt="TSM Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><b>TSM</b> APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->fullname }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @can('customer-list')  
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('customer.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Master List</p>
                </a>
              </li>
             <!--  <li class="nav-item">
                <a href="{{ route('customer.pending') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Customers</p>
                </a>
              </li> -->
              @hasanyrole('Coordinator')             
              <li class="nav-item">
                <a href="{{ route('customer.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-success"></i>
                  <p>Create New</p>
                </a>
              </li> 
              @endhasanyrole           
            </ul>
          </li>
          @endcan 
          @can('order-list')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-inbox"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('order.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-primary"></i>
                  <p>Pending Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('order.complete') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>Completed Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('order.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon  text-success"></i>
                  <p>Create New</p>
                </a>
              </li>            
            </ul>
          </li>
          @endcan
          @can('dsr-list')        
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                DSR
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('dsr.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily Report</p>
                </a>
              </li>      
              <li class="nav-item">
                <a href="{{ route('customer.importview') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Import Customers</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="{{ route('dsr.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>            
            </ul>
          </li>
          @endcan 
          @can('user-list')
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          @endcan 
          @can('pricing-list')
          <li class="nav-item">
            <a href="{{ route('pricing.index') }}" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Pricings
              </p>
            </a>
          </li>
          @endcan
          @can('plan-list')
          <li class="nav-item">
            <a href="{{ route('plan.index') }}" class="nav-link">
              <i class="nav-icon fas fa-phone-alt"></i>
              <p>
                Plans
              </p>
            </a>
          </li>
          @endcan
          @can('role-list')
          <li class="nav-item">
            <a href="{{ route('roles.index') }}" class="nav-link">
              <i class="nav-icon fas fa-unlock-alt"></i>
              <p>
                Permissions
              </p>
            </a>
          </li>
          @endcan
          @can('orderstatus-list')
          <li class="nav-item">
            <a href="{{ route('orderstatus.index') }}" class="nav-link">
              <i class="nav-icon fas fa-toggle-on"></i>
              <p>
                Order Status
              </p>
            </a>
          </li>
          @endcan
          @can('complaint-list')          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-comment-dots"></i>
              <p>
                Complaints
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('complaint.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-primary"></i>
                  <p>Pending Complaints</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('complaint.solved') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>Solved</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('complaint.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon  text-success"></i>
                  <p>Create New</p>
                </a>
              </li>            
            </ul>
          </li> 
          @endcan     
          @can('task-list')          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Tasks
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('task.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Todo List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('task.completed') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>Completed Tasks</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('task.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon  text-success"></i>
                  <p>Create New</p>
                </a>
              </li>            
            </ul>
          </li> 
          @endcan  
          @hasanyrole('Admin')       
          <li class="nav-item has-treeview" id="order-mu">
            <a href="#" class="nav-link">
              <i class="fas fa-user-tag"></i>
              <p>
                Roles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Role</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="{{ route('roles.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>Create Roles</p>
                </a>
              </li>                   
            </ul>
          </li>   
           @endhasanyrole         
          <li class="nav-item">
            <a href="{{ route('cache.clear') }}" class="nav-link">
              <i class="nav-icon fas fa-broom"></i> 
              <p>
                Clear Cache
              </p>
            </a>
          </li>            
          <li class="nav-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
               {{ __('Logout') }}
               <!--  <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>