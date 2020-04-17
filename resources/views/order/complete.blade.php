@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Orders Completed</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Orders Completed</li>
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
          <h3 class="card-title">Completed Order</h3>
          @can('order-create')
            <a class="btn bg-gradient-success btn-sm float-right" href="{{ route('order.create') }}">CREATE NEW</a>
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
            <div class="col-12">
            <form class="form-inline mb-0" method="GET" id="comp-search-frm"> 
              <input type="hidden" name="statusid" value="13">
                @unlessrole('Agent')             
                <div class="form-group mr-2">
                  <select class="form-control" name="userid">   
                    <option value="0">-- By User --</option>                
                    @foreach ($users as $key => $value)
                      <option value="{{ $key }}" {{ (count($fields)>0 && $key == $fields["userid"]) ? 'selected': ''}}> 
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
                      <option value="{{ $key }}" {{ (count($fields)>0 && $key == $fields["parentid"]) ? 'selected': ''}}> 
                          {{ $users[$value] }} 
                      </option>
                    @endforeach    
                  </select>
                </div>
                @endhasanyrole
                
                <!-- Date and time range -->
                <div class="form-group mr-2">
                  <div class="input-group">
                    <input type="hidden" name="start_date" id="start_date" 
                    value="{{ (count($fields)>0)? $fields['start_date'] : '' }}">
                    <input type="hidden" name="end_date" id="end_date" value="{{ (count($fields)>0)? $fields['end_date'] : '' }}">
                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                      <i class="far fa-calendar-alt"></i> Date range picker
                      <i class="fas fa-caret-down"></i>
                    </button>
                  </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-submit mr-2">Search</button>
                    @hasanyrole('Coordinator|Admin')
                      <button type="button" class="btn btn-success btn-export mr-2">Export CSV</button>
                    @endhasanyrole
                    <a href="{{ route('order.complete') }}" class="btn btn-default btn-reset">Reset</a>
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
               <th>OrderId</th>
               <th>Customer</th>
               <th>Status</th>
               <th>Total</th>
               <th>Reffered By</th>
               <th>Created At</th>
               <th>Action</th>                     
            </tr>
            </thead>
            <tbody> 
             @foreach ($data as $key => $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->company_name }} <!-- ({{ $order->account_no }}) --></td>
                <td>{{ ucfirst(str_replace("_", " ", $order->status)) }}</td>
                <td>
                <span class="gray" title="{{ ucfirst($order->plan_type) }}"><i class="fas {{ ($order->plan_type == 'mobile') ? 'fa-mobile-alt' : 'fa-phone-alt' }}"></i></span>&nbsp; {{ $order->total_amount }} </td>
                <td>{{ $order->fullname }}</td>
                <td>{{ date("Y-m-d",strtotime($order->created_at)) }}</td>
                <td>
                   <a class="btn" href="{{  route('order.show',$order->id) }}" title="View Orders"><i class="fas fa-eye"></i></a>  
                </td>
              </tr>
             @endforeach           
            </tbody>
            <tfoot>
            <tr>
               <th>OrderId</th>
               <th>Customer</th>
               <th>Status</th>
               <th>Total</th>
               <th>Reffered By</th>
               <th>Created At</th>
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

    let formData = new FormData($("#comp-search-frm")[0]), 
        data = {},       
        url = "{{ route('order.exportcsv') }}";

    formData.forEach((value, key) => {data[key] = value});
    let querystring = encodeQueryData(data),
        path = url+ '?' +querystring;


    window.location.href = path;
   // window.location.assign(path);

  });
});
</script>
@endsection