@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daily Sales Report</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">DSR</li>
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
          <h3 class="card-title">DSR Management</h3>
          @can('dsr-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('dsr.create') }}">CREATE NEW</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
           <div class="row">
            <div class="col">
            <form class="form-inline mb-0" method="GET" id="ord-search-frm"> 
                @unlessrole('Agent')             
                <div class="form-group mr-2">
                  <select class="form-control" name="userid">   
                    <option value="0">-- By User --</option>                
                    @foreach ($users as $key => $value)
                      <option value="{{ $key }}" {{ (count($fields)>0 && isset($fields["userid"]) && $key == $fields["userid"]) ? 'selected': ''}}> 
                          {{ $value }} 
                      </option>
                    @endforeach    
                  </select>
                </div> 
                @endunlessrole                        
                @hasanyrole('Coordinator|Admin')
                <div class="form-group mr-2">
                  <select class="form-control" name="parentid">   
                    <option value="0">-- By Team --</option>                
                    @foreach ($unique_parent as $key => $value)
                      <option value="{{ $key }}" {{ (count($fields)>0 && isset($fields["parentid"]) && $key == $fields["parentid"] ) ? 'selected': ''}}> 
                          {{ $users[$value] }} 
                      </option>
                    @endforeach    
                  </select>
                </div>
                @endhasanyrole
                <div class="form-group mr-2">
                  <select class="form-control" name="dsr_status">   
                    <option value="0">-- Status --</option>                
                    @foreach ($dsrstatus as $key => $value)
                      <option value="{{ $key }}" {{ (count($fields)>0 && isset($fields["dsr_status"]) && $key == $fields["dsr_status"] )? 'selected': ''}}> 
                          {{ ucwords($value )}} 
                      </option>
                    @endforeach    
                  </select>
                </div>
                <!-- Date and time range -->
                <div class="form-group mr-2">
                  <div class="input-group">
                    <input type="hidden" name="start_date" id="start_date" 
                    value="{{ (count($fields)>0 && isset($fields['start_date']))? $fields['start_date'] : '' }}">

                    <input type="hidden" name="end_date" id="end_date" value="{{ (count($fields)>0 && isset($fields['end_date']))? $fields['end_date'] : '' }}">

                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                      <i class="far fa-calendar-alt"></i> Date range picker
                      <i class="fas fa-caret-down"></i>
                    </button>
                  </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-submit mr-2">Search</button>                    
                    <button type="button" class="btn btn-success btn-export mr-2">Export CSV</button>                    
                    <a href="{{ route('dsr.index') }}" class="btn btn-default btn-reset">Reset</a>
                </div>
                <!-- /.form group -->
              </form>
              </div>          
          </div>
          <div class="row">
            <div class="col">&nbsp;</div>
          </div>
          <table id="order-tbl" class="table table-bordered table-hover">
            <thead>
            <tr>     
               <th>#</th> 
               <th>Company</th>
               <th>Customer</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Status</th>
               <th>By</th>
               <th>Date On</th>
               <th>Action</th>                     
            </tr>
            </thead>
            <tbody> 
             @foreach ($data as $key => $dsr)
             @php
                $ind = ($key == 0)? count($data): $ind-1 ;
                $time = strtotime($dsr->updated_at) + 60*60*4;
              @endphp
              <tr> 
                <td>{{ $ind }}</td>                                 
                <td>{{ $dsr->company }}</td>
                <td>{{ $dsr->contact_name }}</td> 
                <td>{{ $dsr->email }}</td>
                <td>{{ $dsr->phone }}</td>
                <td>
                  @switch($dsr->status)
                    @case('interest')
                        <span class="text-danger">{{ ucfirst($dsr->status) }}</span>
                        @break
                     @case('prospects')
                        <span class="text-danger">{{ ucfirst($dsr->status) }}</span>
                        @break
                    @case('callback')
                        <span class="text-warning">{{ ucfirst($dsr->status) }}</span>
                        @break
                    @case('appointment')
                        <span class="text-warning">{{ ucfirst($dsr->status) }}</span>
                        @break
                     @case('existing')
                        <span class="text-info">{{ ucfirst($dsr->status) }}</span>
                        @break
                    @default
                      <span class="text-muted">{{ ucfirst($dsr->status) }}</span>
                  @endswitch
                </td>
                <td>{{ $dsr->fullname }}</td>
                <td>{{ date("Y-m-d H:i:s", $time) }}</td>
                <td>
                  @can('dsr-edit')
                   <a class="btn" href="{{ route('dsr.edit',$dsr->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan 
                  @can('dsr-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['dsr.destroy', $dsr->id],'style'=>'display:inline']) !!}
                    <button type="submit" class="btn" title="Delete" onclick="return confirmDel('{{ $dsr->company }}' );"><i class="fas fa-trash"></i></button>
                  {!! Form::close() !!}                 
                @endcan
                </td>
              </tr>
             @endforeach           
            </tbody>
            <tfoot>
            <tr>
               <th>#</th>       
               <th>Customer</th>
               <th>Company</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Status</th>
               <th>By</th>
               <th>Date On</th>
               <th>Action</th>             
            </tr>
            </tfoot>
          </table>
          <div class="float-right"> {!! $data->render() !!}</div>
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
function encodeQueryData(data) {
   const ret = [];
   for (let d in data)
     ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
   return ret.join('&');
}
$(document).ready(function(){

  $('.btn-export').on('click', function(e){
    e.preventDefault();

    let formData = new FormData($("#ord-search-frm")[0]), 
        data = {},       
        url = "{{ route('dsr.exportcsv') }}";

    formData.forEach((value, key) => {data[key] = value});
    let querystring = encodeQueryData(data),
        path = url+ '?' +querystring;


    window.location.href = path;
   // window.location.assign(path);

  });
});

function confirmDel(name){
  if(confirm('Are you sure to delete the DSR of '+name+' ?')){
    return true;
  }else{
    return false;
  }
}
</script>

@endsection