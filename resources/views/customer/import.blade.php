@extends('layouts.app')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Customer Import</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Customer Import</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!--  -->
    <div class="row">
      <!-- left column -->     
      <div class="col">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Import Customers List</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          {!! Form::open(array('route' => 'customer.importExl','method'=>'POST', 'enctype' => 'multipart/form-data' )) !!}
            <div class="card-body">
              @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
              @endif
              @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
              @endif
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
            
                  <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="file" required class="custom-file-input" id="file-input" accept=".csv,.xlsx,.xls,.ods">
                        <label class="custom-file-label" for="file-input">Choose a file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                    </div>
                  </div>
                  <p class="mt-1 small text-muted">File extension should be any of xlsx, xls, csv, ods</p>                
                </div> 
                <div id="file-upload" class="text-danger"></div>
                <div id="file-error" class="text-danger mt-1"></div>
                <div class="">
                  Please download the sample format of DSR here <a href="{{ asset('image/Customers.xlsx') }}" download class="text-success ml=1"><b>DOWNLOAD</b></a>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <input type="reset" class="btn btn-default" value="Cancel" name="resetbtn">
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>    
    </div>
 @hasanyrole('Admin')
    <div class="row d-none">
        <!-- left column -->
     
      <div class="col">
        <!-- general form elements -->
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Import Customers Retention</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          {!! Form::open(array('route' => 'customer.importRetention','method'=>'POST', 'enctype' => 'multipart/form-data' )) !!}
            <div class="card-body">
              @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
              @endif
              @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
              @endif
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
            
                  <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="file" required class="custom-file-input" id="file-input-ret">
                        <label class="custom-file-label" for="file-input-ret">Choose a file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                    </div>
                  </div>
                  <p class="mt-1 small text-muted">File extension should be any of xlsx, xls, csv, ods</p>
                </div> 
                <div id="file-upload-ret" class="text-danger"></div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-warning mr-2">Submit</button>
              <input type="reset" class="btn btn-default" value="Cancel" name="resetbtn">
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    @endhasanyrole 
    </div>
</section>

<script type="text/javascript"> 
$(document).ready(function(){
 $('#file-input').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
         
        var data = $(this)[0].files; //this file data       
        $.each(data, function(index, file){ //loop though each file
          let str = file.name;
          
          if(/(\.|\/)(csv|xls?x|ods)$/i.test(str)){ //check supported file type
          
            $('#file-upload').html(str);
          }else{
          
            $('#file-error').html("Selected file extension not allowed");
            return;
          };         
        });
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
        return;
    }
 });

 $('#file-input-ret').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
         
        var data = $(this)[0].files; //this file data       
        $.each(data, function(index, file){ //loop though each file
          let str = file.name;
          $('#file-upload-ret').html(str);
        });
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
    }
 });
}); 
</script>
@endsection