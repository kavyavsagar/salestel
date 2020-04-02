@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Complaints</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Manage Complaints</li>
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
          <h3 class="card-title">Manage Complaints</h3>
          @can('complaint-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('complaint.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="complaint-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>OrderNo</th>
              <th>Priority</th>
              <th>Reported By</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>                  
            </tr>
            </thead>
            <tbody> 
            @foreach ($data as $complaint)              
            <tr>
              <td>{{ $complaint->id }}</td>
              <td>{{ $complaint->order_id }}</td>
              <td>@switch($complaint->priority)
                  @case('high')
                      <span class="text-danger">{{ ucfirst($complaint->priority) }}</span>
                      @break
                  @case('medium')
                      <span class="text-success">{{ ucfirst($complaint->priority) }}</span>
                      @break
                  @default
                      <span class="text-muted">{{ ucfirst($complaint->priority) }}</span>
                  @endswitch
              </td>
              <td>{{ $complaint->fullname }}</td>
              <td>{{ $complaint->status_name }}</td>
              <td>{{ date("d-m-Y", strtotime($complaint->created_at)) }}</td>
              <td>
                <a class="btn" href="{{ route('complaint.show',$complaint->id) }}" title="View Complaint"><i class="fas fa-eye"></i></a>
                @can('complaint-edit')
                 <a class="btn" href="{{ route('complaint.edit',$complaint->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                @endcan                 
                @can('complaint-delete')
                   {!! Form::open(['method' => 'DELETE','route' => ['complaint.destroy', $complaint->id],'style'=>'display:inline']) !!}
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
              <th>OrderNo</th>
              <th>Priority</th>
              <th>Reported By</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>                  
            </tr>                  
            </tr>
            </tfoot>
          </table>
          <div class="float-right"> {!! $data->render() !!}</div>
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