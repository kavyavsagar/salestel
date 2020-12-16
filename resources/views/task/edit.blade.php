@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Task</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('task.index') }}">Task</a></li>
          <li class="breadcrumb-item active">Edit Task</li>
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
            <h3 class="card-title">Edit Task</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
            {!! Form::model($task, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['task.update', $task->id]]) !!}          
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
                    <label for="tasks">Todos</label>
                    {!! Form::textarea('description', null, ['placeholder' => 'Task Description','class' => 'form-control','id' => 'tasks', 'rows' => 4, 'cols' => 54]) !!}
                </div> 
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority"> 
                        <option value="low" {{ ( 'low' == $task->priority) ? 'selected' : '' }}>Low</option> 
                        <option value="medium" {{ ( 'medium' == $task->priority) ? 'selected' : '' }}>Medium</option>   
                        <option value="high" {{ ( 'high' == $task->priority) ? 'selected' : '' }}>High</option>    
                    </select>
                </div>
                <!-- Date dd/mm/yyyy -->
    

                <div class="row">
                  <div class="col">
                      <div class="form-group">
                      <label>Start Date:</label>
                      <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="start_date" value="{{$task->start_date? date('m/d/Y', strtotime($task->start_date)): ''}}"/>
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
                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="start_time" value="{{ $task->start_time? $task->start_time : ''}}"/>
                            <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                        </div>
                        <small class="text-secondary"> Click icon to select time</small>
                      </div>
                  </div>
                </div> 
                           
                <div class="form-group">
                    <label>Reffered By:</label>
                    <select class="form-control" name="assigned_by">   
                      <option value="">-- Select --</option>                
                      @foreach ($users as $key => $value)
                        <option value="{{ $key }}" {{ ( $key == $task->assigned_by) ? 'selected' : '' }}> 
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
$(document).ready(function(){
 $('#file-input').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
        var data = $(this)[0].files; //this file data
         
        $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(bmp|jpe?g|png)$/i.test(file.type) || file.type.match('application/pdf')){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                        return function(e) {                           
                            let preview = '';
                            if(file.type.match('application/pdf')){
                                preview = $('<p/>').addClass('text-danger m-1').html(file.name);
                            }else{
                                preview = $('<img/>').addClass('img-fluid img-thumbnail m-1 mht-100').attr('src', e.target.result); //create image element 
                            }
                            
                            $('#thumb-output').append(preview); //append image to output element
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                    $('#file-error').html("");
                }else{                        
                    $('#file-error').html("Selected file extension not allowed");
                    return;
                }; 
            });
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
    }
 });

 /*************************  ********************************/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var fnajx = function(value){ 
        var query = value;      
        if(query != '')
        {
        // var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"{{ route('customer.fetch') }}",
            method:"POST",
            data:{query:query}, //, _token:_token
            success:function(data){
              $('#companyList').fadeIn();  
              $('#companyList').html(data);
            }
        });
        }
    };
    $( "#customerext" ).on({
        keyup: function() {
            console.log( "keyup over a div" );
            let v = $(this).val();
            fnajx(v);
        },
        paste: function(e) {
            console.log( "paste left a div" );
            var clipboardData = e.clipboardData || e.originalEvent.clipboardData || window.clipboardData;
            var pastedData = clipboardData.getData('text');
            fnajx(pastedData);
        }
    });

    // $('#customerext').keyup(function(){ 
    //     var query = $(this).val();
    //     if(query != '')
    //     {
    //     // var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url:"{{ route('customer.fetch') }}",
    //         method:"POST",
    //         data:{query:query}, //, _token:_token
    //         success:function(data){
    //           $('#companyList').fadeIn();  
    //           $('#companyList').html(data);
    //         }
    //     });
    //     }
    // });

    $(document).on('click', '#companyList > ul > li', function(){  
        let str = $(this).text();
        $('#customerext').val(str);        
        $('#companyList').fadeOut();        

    }); 

    $('#datetimepicker3').datetimepicker({
        format: 'LT'
    });
    $('#datetimepicker4').datetimepicker({
        format: 'L'
    });
    
}); 
</script>
@endsection