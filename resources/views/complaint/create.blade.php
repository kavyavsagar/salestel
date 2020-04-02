@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Create Complaint</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('complaint.index') }}">Complaint</a></li>
          <li class="breadcrumb-item active">Create Complaint</li>
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
            <h3 class="card-title">New Complaint</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
            {!! Form::open(array('route' => 'complaint.store','method'=>'POST', 'enctype' => 'multipart/form-data' )) !!}
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
                    <label for="orderid">Order ID</label>
                    {!! Form::text('order_id', null, array('placeholder' => 'Order ID','class' => 'form-control', 'id' => 'orderid')) !!}
                </div> 
                <div class="form-group">
                    <label for="complaint">Complaint</label>
                    {!! Form::textarea('description', null, ['placeholder' => 'Complaint Description','class' => 'form-control','id' => 'complaint', 'rows' => 4, 'cols' => 54]) !!}
                </div> 
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority"> 
                        <option value="low">Low</option> 
                        <option value="medium">Medium</option>   
                        <option value="high">High</option>    
                    </select>
                </div> 
                <div class="form-group">
                    <label>Reffered By:</label>
                    <select class="form-control" name="reported_by">   
                      <option value="">-- Select --</option>                
                      @foreach ($users as $key => $value)
                        <option value="{{ $key }}"> 
                            {{ $value }} 
                        </option>
                      @endforeach    
                    </select>                    
                </div>                
                <div class="form-group">
                    <label>Upload all documents:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file-input" name="filepath">
                            <label class="custom-file-label" for="file-input">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                        </div>
                    </div>
                    <span class="text-danger">{{ $errors->first('filepath') }}</span>           
                </div>
                <div class="form-group">
                     <div id="thumb-output"></div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-default float-right" href="{{ route('complaint.index') }}"> Cancel</a>
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
            if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                var fRead = new FileReader(); //new filereader
                fRead.onload = (function(file){ //trigger function on successful read
                return function(e) {
                    var img = $('<img/>').addClass('img-fluid img-thumbnail m-1 mht-100').attr('src', e.target.result); //create image element 
                    $('#thumb-output').html(img); //append image to output element
                };
                })(file);
                fRead.readAsDataURL(file); //URL representing the file's data.
            }
        });
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
    }
 });
}); 
</script>
@endsection