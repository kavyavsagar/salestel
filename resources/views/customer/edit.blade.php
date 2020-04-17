@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
          <li class="breadcrumb-item active">Edit Customer</li>
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
            <h3 class="card-title">Edit Customer</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->          
           {!! Form::model($customer, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['customer.update', $customer->id]]) !!}
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

            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Company Name:</label>
                        {!! Form::text('company_name', null, array('placeholder' => 'Company Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Account Number:</label>
                        {!! Form::text('account_no', null, array('placeholder' => 'Account No.','class' => 'form-control')) !!}
                    </div>
                </div>     
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Location:</label>
                        {!! Form::text('location', null, array('placeholder' => 'Location','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>  
            <div class="row">  
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <label class="text-uppercase">Authorized Person Details</label>
                    <hr/> 
                </div>
            </div>
            <div class="row">      
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Person Name:</label>
                        {!! Form::text('authority_name', null, array('placeholder' => 'Authority Name','class' => 'form-control')) !!}
                    </div>
                </div>  
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Email:</label>
                        {!! Form::text('authority_email', null, array('placeholder' => 'Authority Email','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Mobile</label>
                        {!! Form::text('authority_phone', null, array('placeholder' => 'Authority Mobile','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <label class="text-uppercase">Technical Person Details</label>
                    <hr/>
                </div>
            </div>  
            <div class="row">   
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Contact Name:</label>
                        {!! Form::text('technical_name', null, array('placeholder' => 'Technical Name','class' => 'form-control')) !!}
                    </div>
                </div>  
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Email:</label>
                        {!! Form::text('technical_email', null, array('placeholder' => 'Technical Email','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Mobile</label>
                        {!! Form::text('technical_phone', null, array('placeholder' => 'Technical Mobile','class' => 'form-control')) !!}
                    </div>
                </div>   
            </div>
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-md-6"> 
                    <div class="form-group">
                        <label>Upload all documents:</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file-input" name="image[]" multiple="">
                                <label class="custom-file-label" for="file-input">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                            </div>
                        </div>
                        <span class="text-danger">{{ $errors->first('image') }}</span>           
                    </div>        
                </div>  
                <div class="col-xs-12 col-sm-6 col-md-6">           
                    @hasanyrole('Coordinator|Admin')
                    <div class="form-group">
                        <label>Reffered By:</label>
                        <select class="form-control" name="refferedby">   
                            <option value="0">-- Select --</option>                
                            @foreach ($users as $key => $value)
                              <option value="{{ $key }}" {{ ($key == $customer->refferedby)? 'selected': ''}}> 
                                {{ $value }} 
                              </option>
                            @endforeach    
                        </select>            
                    </div>
                    @else
                      <input type="hidden" name="refferedby" value="{{$customer->refferedby}}">
                    @endhasanyrole 
                </div>  
            </div>  
            <div class="row">  
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @foreach ($documents as $key => $doc)
                    <div id="{{$key}}" class="d-inline">    
                       <img src="{{asset($doc)}}" class="img-fluid img-thumbnail m-1 mht-100">
                    </div>
                    @endforeach 
                </div>
            </div>
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="thumb-output"></div>
                </div>
            </div>  
          </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-default float-right" href="{{ route('customer.index') }}"> Cancel</a>
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
                    $('#thumb-output').append(img); //append image to output element
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