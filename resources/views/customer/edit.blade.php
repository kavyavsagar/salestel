@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New Customer</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('customer.index') }}"> Back</a>
        </div>
    </div>
</div>


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


{!! Form::model($customer, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['customer.update', $customer->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Company Name:</strong>
            {!! Form::text('company_name', null, array('placeholder' => 'Company Name','class' => 'form-control')) !!}
        </div>
    </div>    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Location:</strong>
            {!! Form::text('location', null, array('placeholder' => 'Location','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">       
        <strong class="text-uppercase">Authorized Person Details</strong>
        <hr/>            
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Person Name:</strong>
            {!! Form::text('authority_name', null, array('placeholder' => 'Authority Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('authority_email', null, array('placeholder' => 'Authority Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Mobile</strong>
            {!! Form::text('authority_phone', null, array('placeholder' => 'Authority Mobile','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <strong class="text-uppercase">Technical Person Details</strong>
        <hr/>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Contact Name:</strong>
            {!! Form::text('technical_name', null, array('placeholder' => 'Technical Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('technical_email', null, array('placeholder' => 'Technical Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Mobile</strong>
            {!! Form::text('technical_phone', null, array('placeholder' => 'Technical Mobile','class' => 'form-control')) !!}
        </div>
    </div>   
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Reffered By:</strong>
            <select class="form-control" name="refferedby">   
              <option value="0">-- Select --</option>                
              @foreach ($users as $key => $value)
                <option value="{{ $key }}" {{ ( $key == $customer->refferedby) ? 'selected' : '' }}> 
                    {{ $value }} 
                </option>
              @endforeach    
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"> 
        <div class="form-group">
            <strong>Upload all documents:</strong>
            <input type="file" id="file-input" name="image[]" multiple="" class="form-control">
            <span class="text-danger">{{ $errors->first('image') }}</span>
            <br>
            <div id="thumb-output"></div>
        </div>             
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"> <br></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        @foreach ($documents as $key => $doc)
        <div id="{{$key}}" class="thumbimg">    
           <img src="{{url($doc)}}" class="thumb">
        </div>
        @endforeach 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"> <br></div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}

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
                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
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