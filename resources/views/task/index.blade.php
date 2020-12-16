@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Todo Lists</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Manage Tasks</li>
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
          <h3 class="card-title">Manage Tasks</h3>
          @can('task-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('task.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif

          <table id="task-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Task</th>
              <th>Date</th>
              <th>Priority</th>             
              <th>Assined By</th>
           <!--    <th>Status</th> -->
              
              <th>Action</th>                  
            </tr>
            </thead>
            <tbody> 
            @foreach ($data as $ind => $task)   
              @php
                $time = strtotime($task->created_at) + 60*60*4;
              @endphp           
            <tr>
              <td>{{ ($ind + 1) }}</td>
              <td>{{ substr($task->description,0, 80 ) }}..</td>
               <td>{{ $task->start_date }}</td>
              <td>@switch($task->priority)
                  @case('high')
                      <span class="text-danger">{{ ucfirst($task->priority) }}</span>
                      @break
                  @case('medium')
                      <span class="text-success">{{ ucfirst($task->priority) }}</span>
                      @break
                  @default
                      <span class="text-muted">{{ ucfirst($task->priority) }}</span>
                  @endswitch
              </td>
              <td>{{ $task->fullname }}</td>              
<!--               <td>@switch($task->status)
                  @case(1)
                      <span class="text-muted">Todo</span>
                      @break
                  @case(2)
                      <span class="text-success">Completed</span>
                      @break
                  @default
                      <span class="text-danger"></span>
                  @endswitch</td> -->             
              <td>
                <a class="btn" href="{{ route('task.show',$task->id) }}" title="View & Comment"><i class="fas fa-eye"></i></a>
                @can('task-edit')
                 <a class="btn" href="{{ route('task.edit',$task->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                @endcan
                @can('task-edit')
                   {!! Form::open(['method' => 'POST','route' => 'task.changestatus','style'=>'display:inline']) !!}
             
                   <input type="hidden" name="taskid" value="{{$task->id}}"/>
                   <input type="hidden" name="comment" value="Mark as completed"/>
                   <input type="hidden" name="status" value="2"/>
                   <input type="hidden" name="return" value="task.index"/>
                  <button type="submit" class="btn" name="task"><i class="far fa-check-circle"></i></button>
                  {!! Form::close() !!}
                @endcan                 
                @can('task-delete')
                   {!! Form::open(['method' => 'DELETE','route' => ['task.destroy', $task->id],'style'=>'display:inline']) !!}
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
              <th>Task</th>
              <th>Priority</th>
              <th>Reported By</th>
        <!--       <th>Status</th> -->
              <th>Date</th>
              <th>Action</th>                  
            </tr>                  
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