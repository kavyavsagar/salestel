@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
          <li class="breadcrumb-item active">View Customer</li>
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
      <div class="col-xs-12 col-sm-4 col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Customer Details
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">          
            <dl class="row">
              <dt class="col-sm-4">Company Name</dt>
              <dd class="col-sm-8">{{ $customer->company_name }}</dd>
              <dt class="col-sm-4">Location</dt>
              <dd class="col-sm-8">{{ $customer->location }}</dd>         
              <dt class="col-sm-4">Reffered by</dt>
              <dd class="col-sm-8">{{ $customer->fullname }}</dd>     
            </dl>
          </div>
          <!-- /.card-body -->    
        </div>
      </div>
     
      <!-- left column -->     
      <div class="col-xs-12 col-sm-4 col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Authority Details
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">          
            <dl class="row">              
              <dt class="col-sm-4">Contact Name</dt>
              <dd class="col-sm-8">{{ $customer->authority_name }}</dd>
              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8"> {{ $customer->authority_email }}</dd>
              <dt class="col-sm-4">Phone</dt>
              <dd class="col-sm-8">{{ $customer->authority_phone }}</dd>                         
            </dl>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
     
      <!-- left column -->     
      <div class="col-xs-12 col-sm-4 col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Technical Details
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">          
            <dl class="row">              
              <dt class="col-sm-4">Contact Person</dt>
              <dd class="col-sm-8">{{ $customer->technical_name }}</dd>
              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8"> {{ $customer->technical_email }}</dd>
              <dt class="col-sm-4">Phone</dt>
              <dd class="col-sm-8">{{ $customer->technical_phone }}</dd>                        
            </dl>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      </div>

      <div class="row">
        <!-- left column -->     
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Documents
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">          
            <dl class="row">         
              <dd class="col-sm-12">
                @foreach ($documents as $key => $doc)
                    <div id="{{$key}}" class="d-inline">    
                       <img src="{{url($doc)}}" class="img-fluid img-thumbnail m-1 mht-100">
                    </div>
                @endforeach
              </dd>       
            </dl>
          </div>
          <!-- /.card-body -->  
          <div class="card-footer">
              <a class="btn btn-default float-right" href="{{ route('customer.index') }}"> Cancel</a>
          </div>  
        </div>
      </div>
    </div>

    </div>
</section>

@endsection