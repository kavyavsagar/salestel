@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Order Status</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Order Status</li>
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
          <h3 class="card-title">Manage Status</h3>
          @can('orderstatus-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('orderstatus.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="order-status-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Status</th>
              <th>Action</th>                  
            </tr>
            </thead>
            <tbody> 
            @foreach ($orderstatus as $status)              
            <tr>
              <td>{{ $status->id }}</td>
              <td>{{ ucwords(str_replace("_"," ",$status->name)) }}</td>
              <td>               
                  @can('orderstatus-edit')
                    <a class="btn" href="{{ route('orderstatus.edit',$status->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan                 
                  @can('orderstatus-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['orderstatus.destroy', $status->id],'style'=>'display:inline']) !!}
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
              <th>Status</th>
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