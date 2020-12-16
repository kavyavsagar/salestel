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
              <dd class="col-sm-8">{{ $customer->company_name }} </dd>
              <dt class="col-sm-4">Account Number</dt>
              <dd class="col-sm-8">{{ $customer->account_no }}</dd>              
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
              <dt class="col-sm-4">&nbsp;</dt>
              <dd class="col-sm-8">&nbsp;</dd>                   
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
              <dt class="col-sm-4">&nbsp;</dt>
              <dd class="col-sm-8">&nbsp;</dd>                      
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
                @if(!count($documents))  
                  <div class="d-inline text-muted">No documents !!</div>
                @endif
                @foreach ($documents as $key => $doc)
                    <div id="{{$key}}" class="d-inline">                       
                    @php
                      $file_parts = pathinfo($doc);
                    @endphp
                    @if($file_parts['extension'] == 'pdf')
                      <a href="{{asset($doc)}}" download>{{ explode("/",$doc)[1] }}</a><br/>
                    @else
                       <a href="{{asset($doc)}}" download><img src="{{asset($doc)}}" class="img-fluid img-thumbnail m-1 mht-100"></a>
                    @endif
                    </div>
                @endforeach
                
              </dd>       
            </dl>
          </div>
          @if(count($documents) > 0) 
          <div class="card-footer"> 
            @can('customer-delete')
               {!! Form::open(['method' => 'DELETE','route' => ['customer.destroy', $customer->id],'style'=>'display:inline']) !!}
              <input type="hidden" name="doc_del" value="true">
              <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirmDel('{{ $customer->company_name }}' );"><i class="fas fa-trash"></i> Clear All</button>
              {!! Form::close() !!}
            @endcan
          </div>
          @endif
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
              <i class="fas fa-inbox"></i>&nbsp;
              Order and Plan History
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">  

            <div class="table-responsive p-0">
              <table class="table table-striped table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th scope="col">Order</th>
                    <th scope="col">Status</th> 
                    <th scope="col">Date</th> 
                    <th scope="col">MRC</th>
                    <th scope="col">PLAN</th>
                    <th scope="col">TYPE/Nos.</th>
                    <th scope="col">QTY</th>
                    <th scope="col">TOTAL (AED)</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(!count($orders))  
                  <tr>
                      <td colspan="7" align="center">No Order Plans !!</td>
                  </tr>
                  @endif
                  @foreach ($orders as $key => $plan)
                  <tr>
                      <th scope="row">#{{$plan->id}} - {{ ucfirst($plan->plan_type) }}</th>
                      <td>{{ ucwords(str_replace("_"," ",$plan->status)) }}</td>
                      <td>{{ date("d/m/Y", strtotime($plan->created_at)) }}</td>
                      <th scope="row">{{$plan->price}}</th>
                      <td>{{$plan->plan}}</td>
                      <td>{{$plan->ptype}}<p>{{$plan->phoneno}}</p></td>
                      <td>{{$plan->quantity}}</td>
                      <td>{{$plan->total}}</td>
                  </tr>                
                  @endforeach  
                  </tbody>
              </table>
            </div>            
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
<script type="text/javascript">
function confirmDel(name){
  if(confirm('Are you sure to delete all documents of '+name+' ?')){
    return true;
  }else{
    return false;
  }
}
</script>
@endsection          