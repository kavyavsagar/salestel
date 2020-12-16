@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Master List</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Master List</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col">

        <div class="card">
        <div class="card-header">
          <h3 class="card-title">Master List Management</h3>
         <!--  @can('customer-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('customer.create') }}">CREATE NEW</a>
          @endcan -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <table id="customer-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>
             <th>#</th>
             <th>Company</th>
             <th>Account No.</th>
             <th>Person</th>
             <th>Phone</th>
             <th>Reffered By</th>
             <th >Action</th>                
            </tr>
            </thead>
            <tbody> 
            @foreach ($data as $key => $customer)         
            <tr>
              <td>{{ $customer->id }}</td>
              <td>{{ $customer->company_name }} </td>
              <td>{{ $customer->account_no }}</td>
              <td>{{ $customer->authority_name }}</td>
              <td>{{ $customer->authority_phone }}</td>
              <td>{{ $customer->fullname }}</td>        
              <td>    
                <a class="btn" href="{{ route('customer.show',$customer->id) }}" title="View Customer"><i class="fas fa-eye"></i></a>
                @can('customer-edit')
                 <a class="btn" href="{{ route('customer.edit',$customer->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                @endcan                 
                @can('customer-delete')
                   {!! Form::open(['method' => 'DELETE','route' => ['customer.destroy', $customer->id],'style'=>'display:inline']) !!}
                  <button type="submit" class="btn" title="Delete" onclick="return confirmDel('{{ $customer->company_name }}' );"><i class="fas fa-trash"></i></button>
                  {!! Form::close() !!}
                @endcan
              </td>
            </tr>
            @endforeach  
            </tbody>
            <tfoot>
            <tr>
             <th>#</th>
             <th>Company</th>
             <th>Account No.</th>
             <th>Person</th>
             <th>Phone</th>
             <th>Reffered By</th>
             <th>Action</th>               
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- <div class="col">&nbsp;</div> -->
    </div>
  </div>
</section> 
<!-- /.content -->
<script type="text/javascript">
function confirmDel(name){
  if(confirm('Are you sure to delete the customer '+name+' ?')){
    return true;
  }else{
    return false;
  }
}
</script>

@endsection