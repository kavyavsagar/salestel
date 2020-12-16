@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View Task</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('task.index') }}">Tasks</a></li>
          <li class="breadcrumb-item active">View Task</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
     
      <div class="col">
        <!-- general form elements -->
         <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Task Details - #{{ $task->id }}
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">          
            <dl class="row">              
              <dt class="col-sm-4">Task</dt>
              <dd class="col-sm-8">{{ $task->description }}</dd>      
              <dt class="col-sm-4">Start Date</dt>
              <dd class="col-sm-8">{{ $task->start_date }}</dd>    
              <dt class="col-sm-4">Priority</dt>
              <dd class="col-sm-8">
                  @switch($task->priority)
                      @case('high')
                          <span class="text-danger">{{ ucfirst($task->priority) }}</span>
                          @break
                      @case('medium')
                          <span class="text-success">{{ ucfirst($task->priority) }}</span>
                          @break
                      @default
                          <span class="text-muted">{{ ucfirst($task->priority) }}</span>
                  @endswitch
              </dd>             
              <dt class="col-sm-4">Assigned by</dt>
              <dd class="col-sm-8">{{ $task->fullname }}</dd> 
              <dt class="col-sm-4">Status</dt>
              <dd class="col-sm-8">{{ ($task->status == 1)?'Processing' : 'Completed' }}</dd>             
              <dt class="col-sm-4">Posted Date</dt>
              <dd class="col-sm-8">
                @php
                  $time = strtotime($task->created_at) + 60*60*4;
                @endphp  
                {{ date("d-m-Y H:i:s", $time)}}</dd>  

            </dl>            
          </div>
          <!-- /.card-body --> 
          <div class="card-footer">
              <a class="btn btn-default float-right" href="{{ route('task.index') }}">Back</a>
          </div>   
        </div>
       <!-- /.card -->
     </div>
     <!-- col -->    
    </div>
    <div class="row">     
      <div class="col"><br/></div>
    </div>
    <div class="row">
        <!-- left column -->     
      <div class="col">
        {!! Form::open(array('route' => 'task.changestatus','method'=>'POST' )) !!} 
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Add Comments
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body"> 
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                   @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                   @endforeach
                </ul>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
            @endif

            <div class="form-group">
                {!! Form::textarea('comment', null, ['placeholder' => 'Add comments','class' => 'form-control','id' => 'comment', 'rows' => 4, 'cols' => 50]) !!}         
            </div>  
          </div>
           <div class="card-footer">
                <input type="hidden" name="taskid" value="{{$task->id}}">
                <input type="hidden" name="return" value="task.show">
                <button type="submit" class="btn btn-primary btn-submit mr-3">Update</button>
                <a class="btn btn-default float-right" href="{{ route('task.index') }}">Cancel</a>
          </div>
        </div>      
        {!! Form::close() !!}
      </div>
    </div>
    <div class="row">     
      <div class="col"><br/></div>
    </div>
    <div class="row"> 
      <div class="col">    
        <div class="card">     
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-comment-dots"></i> Task History
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body"> 
            <p>List all the comments and status based on this task</p>        
            <div class="table-responsive p-0">
            <table class="table table-striped table-hover text-nowrap">
                <thead>
                <tr>
                  <th scope="col">Comments</th>
                  <th scope="col">Added By</th>
                  <th scope="col">Date Added</th>
                </tr>
                </thead>
                <tbody>  
                @foreach ($histories as $key => $hist)
                <tr>                 
                  <td width="40%">{{$hist->comment}}</td>            
                  <td>{{$hist->fullname}}</td>
                  <td>
                    @php
                      $time = strtotime($hist->created_at) + 60*60*4;
                    @endphp  
                    {{ date("d-m-Y H:i:s", $time)}}
                  </td>
                </tr>
                @endforeach                            
                </tbody>
            </table>
            </div>
          </div>
       </div>
      </div>
    </div>
    </div>
</section>


@endsection
