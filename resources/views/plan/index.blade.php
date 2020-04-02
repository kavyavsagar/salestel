@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Plans</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Plans</li>
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
          <h3 class="card-title">Manage Plans</h3>
          @can('plan-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('plan.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="plan-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Plan Type</th>
              <th>Action</th>                  
            </tr>
            </thead>
            <tbody> 
             @foreach ($plans as $key => $plan)
              <tr>
                <td>{{ $plan->id }}</td>
                <td>{{ $plan->plan }}</td>
                <td><i class="fas {{ ($plan->plan_type == 'mobile') ? 'fa-mobile-alt' : 'fa-phone-alt' }}"></i>&nbsp;
                {{ ucwords($plan->plan_type) }}</td>
                <td>
                  @can('plan-edit')
                    <a class="btn" href="{{ route('plan.edit',$plan->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan
                  @can('plan-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['plan.destroy', $plan->id],'style'=>'display:inline']) !!}
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
              <th>Plan Type</th>
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