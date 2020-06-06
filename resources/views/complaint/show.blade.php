@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View Complaint</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('complaint.index') }}">Complaint</a></li>
          <li class="breadcrumb-item active">Edit Complaint</li>
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
              Complaint Details - #{{ $complaint->id }}
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">          
            <dl class="row">
              <dt class="col-sm-4">Customr Account No.</dt>
              <dd class="col-sm-8">{{ $complaint->customer_acc_no }}</dd>
              <dt class="col-sm-4">Details</dt>
              <dd class="col-sm-8">{{ $complaint->description }}</dd>         
              <dt class="col-sm-4">Priority</dt>
              <dd class="col-sm-8">
                  @switch($complaint->priority)
                      @case('high')
                          <span class="text-danger">{{ ucfirst($complaint->priority) }}</span>
                          @break
                      @case('medium')
                          <span class="text-success">{{ ucfirst($complaint->priority) }}</span>
                          @break
                      @default
                          <span class="text-muted">{{ ucfirst($complaint->priority) }}</span>
                  @endswitch
              </dd>             
              <dt class="col-sm-4">Reported by</dt>
              <dd class="col-sm-8">{{ $complaint->fullname }}</dd> 
              <dt class="col-sm-4">Status</dt>
              <dd class="col-sm-8">{{ ucwords($complaint->status_name) }}</dd>             
              <dt class="col-sm-4">Posted Date</dt>
              <dd class="col-sm-8">{{ date("d-m-Y", strtotime($complaint->created_at)) }}</dd>  
              @if($complaint->filepath)
                <dd class="col-sm-12">   
                   <img src="{{asset($complaint->filepath)}}" class="img-fluid img-thumbnail m-1 mht-100">
                </dd>  
              @endif 
                 
            </dl>            
          </div>
          <!-- /.card-body --> 
          <div class="card-footer">
              <a class="btn btn-default float-right" href="{{ route('complaint.index') }}">Back</a>
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
        {!! Form::open(array('route' => 'complaint.changestatus','method'=>'POST' )) !!} 
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Change Status 
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
                <select class="form-control" name="status" id="cstatus">                 
                    @foreach ($statuses as $key => $value) 
                    <option value="{{ $value->id }}" {{ ( $value->id == $complaint->status ) ? 'selected' : '' }}> 
                        {{ ucwords($value->name) }} 
                    </option>
                    @endforeach    
                </select>          
            </div>
            <div class="form-group">
                {!! Form::textarea('comment', null, ['placeholder' => 'Add comments','class' => 'form-control','id' => 'comment', 'rows' => 4, 'cols' => 50]) !!}         
            </div>  
          </div>
           <div class="card-footer">
                <input type="hidden" name="complaintid" value="{{$complaint->id}}">
                <button type="submit" class="btn btn-primary btn-submit mr-3">Update Status</button>
                <a class="btn btn-default float-right" href="{{ route('complaint.index') }}">Cancel</a>
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
              <i class="fas fa-comment-dots"></i> Complaint History
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body"> 
            <p>List all the comments and status based on this complaint</p>        
            <div class="table-responsive p-0">
            <table class="table table-striped table-hover text-nowrap">
                <thead>
                <tr>
                  <th scope="col">Status</th>
                  <th scope="col">Comments</th>
                  <th scope="col">Added By</th>
                  <th scope="col">Date Added</th>
                </tr>
                </thead>
                <tbody>  
                @foreach ($histories as $key => $hist)
                <tr>
                  <th scope="row">{{ucwords($hist->status_name)}} </th>
                  <td>{{$hist->comment}}</td>            
                  <td>{{$hist->fullname}}</td>
                  <td>{{date("d/m/Y", strtotime($hist->created_at))}}</td>
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
