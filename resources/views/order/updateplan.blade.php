@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Update Plan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
          <li class="breadcrumb-item active">Update Plan</li>
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
        {!! Form::open(array('route' => 'order.saveplan','method'=>'POST', 'autocomplete' => "off" )) !!}
        <div class="card">   
          <div class="card-header">
          </div>
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
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="form-group">
                      <label>Company / Account Number:</label>
                      <input type="text" name="account_no" id="account_no" class="form-control input-lg" placeholder="Company / Account No" />
                      <div id="companyList">
                      </div>
                     
                  </div>
                </div>    
                <div class="col-xs-12 col-sm-6 col-md-6">
                   
                </div>
              </div>
          <!-- /.card-body -->           
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-default float-right" href="{{ route('customer.index') }}"> Cancel</a>
          </div>          
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
$(document).ready(function(){
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  $('#account_no').keyup(function(){ 
      var query = $(this).val();
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
  });

  $(document).on('click', '#companyList > ul > li', function(){  
      $('#account_no').val($(this).text());  
      $('#companyList').fadeOut();  
  });  

});
</script>
@endsection