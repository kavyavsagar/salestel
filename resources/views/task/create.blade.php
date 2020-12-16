@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Create Task</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('complaint.index') }}">Task</a></li>
          <li class="breadcrumb-item active">Create Task</li>
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
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">New Task</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
            {!! Form::open(array('route' => 'task.store','method'=>'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off' )) !!}
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
                <div class="form-group">
                    <label for="complaint">Task</label>
                    {!! Form::textarea('description', null, ['placeholder' => 'Task Description','class' => 'form-control','id' => 'complaint', 'rows' => 4, 'cols' => 54]) !!}
                </div> 
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority"> 
                        <option value="low">Low</option> 
                        <option value="medium">Medium</option>   
                        <option value="high">High</option>    
                    </select>
                </div> 
           
                <div class="row">
                  <div class="col">
                      <div class="form-group">
                      <label>Start Date:</label>
                      <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="start_date"/>
                          <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                          </div>
                      </div>
                      <small class="text-secondary"> Click icon to select date</small>
                      </div>
                  </div>
                  <div class="col">
                      <div class="form-group">
                      <label>Start Time:</label>
                        <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="start_time"/>
                            <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                        </div>
                        <small class="text-secondary"> Click icon to select time</small>
                      </div>
                  </div>
                </div>               
                <!-- /.form group -->
                <div class="form-group">
                    <label>Reffered By:</label>
                    <select class="form-control" name="assigned_by">   
                      <option value="">-- Select --</option>                
                      @foreach ($users as $key => $value)
                        <option value="{{ $key }}"> 
                            {{ $value }} 
                        </option>
                      @endforeach    
                    </select>                    
                </div>               
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-default float-right" href="{{ route('task.index') }}"> Cancel</a>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker3').datetimepicker({
            format: 'LT'
        });
        $('#datetimepicker4').datetimepicker({
            format: 'L'
        });
    });
</script>
@endsection
