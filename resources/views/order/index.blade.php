@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Orders</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
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
          <h3 class="card-title">Order Management</h3>
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
            <div class="col">
            <form class="form-inline mb-0" method="GET" id="ord-search-frm"> 
                <div class="form-group mr-2">
                  <select class="form-control" name="statusid[]" multiple>   
                    <option value="0">-- By Status --</option>                
                    @foreach ($ordstatus as $key => $value) 
                      <option value="{{ $key }}" {{ (isset( $fields["statusid"]) && 
                      in_array($key,$fields["statusid"])) ? 'selected': ''}}> 
                          {{ ucwords(str_replace("_"," ",$value)) }} 
                      </option>
                    @endforeach    
                  </select>
                </div>
                @unlessrole('Agent')             
                <div class="form-group mr-2">
                  <select class="form-control" name="userid">   
                    <option value="0">-- By User --</option>                
                    @foreach ($users as $key => $value)
                      <option value="{{ $key }}" {{ (isset( $fields["userid"]) && $key == $fields["userid"]) ? 'selected': ''}}> 
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
                      <option value="{{ $key }}" {{ (isset( $fields["parentid"]) && $key == $fields["parentid"]) ? 'selected': ''}}> 
                          {{ $users[$value] }} 
                      </option>
                    @endforeach    
                  </select>
                </div>
                @endhasanyrole
                <div class="form-group mr-2">
                  <select class="form-control" name="mrc">   
                    <option value="0">-- By MRC --</option>   
                    <option value="1-500" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    0-500 
                    </option>
                    <option value="501-1000" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    501-1000
                    </option>
                    <option value="1001-2000" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    1001-2000
                    </option>
                    <option value="2001-3000" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    2001-3000
                    </option>
                    <option value="3001-4000" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    3001-4000
                    </option>
                    <option value="4001-5000" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    4001-5000
                    </option>
                    <option value="5001-10000" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    5001-10000
                    </option>
                    <option value="10001-0" {{ (isset( $fields["mrc"]) && $key == $fields["mrc"]) ? 'selected': ''}}>
                    > 10000
                    </option>
                  </select>
                </div> 
                <!-- Date and time range -->
                <div class="form-group mr-2">
                  <div class="input-group">
                    <input type="hidden" name="start_date" id="start_date" 
                    value="{{ isset( $fields['start_date']) ? $fields['start_date'] : '' }}">
                    <input type="hidden" name="end_date" id="end_date" value="{{ isset( $fields['end_date']) ? $fields['end_date'] : '' }}">
                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                      <i class="far fa-calendar-alt"></i> Date range picker
                      <i class="fas fa-caret-down"></i>
                    </button>
                  </div>
                </div>
                <div class="form-group mr-2">
                  <select class="form-control" name="planid">   
                    <option value="0">-- Plan --</option>                
                    @foreach ($plans as $key => $plan)
                      <option value="{{ $plan->plan_id.'_'.$plan->price }}" {{ (isset( $fields["planid"]) && ($plan->plan_id.'_'.$plan->price) == $fields["planid"]) ? 'selected': ''}}>{{ ucwords($plan->plan).' - '. $plan->price }} 
                      </option>
                    @endforeach    
                  </select>
                </div>
                <div class="form-group mr-2">
                  <input type="text" class="form-control" name="searhkey" placeholder="Company Name.." 
                  value="{{ (isset($fields['searhkey']) && $fields['searhkey'] <> '')? $fields['searhkey']: ''}}" />
                </div>
                <br/>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-submit mr-2">Search</button>
                    @hasanyrole('Coordinator|Admin|Team Lead')
                      <button type="button" class="btn btn-success btn-export mr-2 disabled">Export CSV</button>
                    @endhasanyrole
                    <a href="{{ route('order.index') }}" class="btn btn-default btn-reset">Reset</a>
                </div>
                <!-- /.form group -->
              </form>
              </div>          
          </div>
          <div class="row">
            <div class="col"><hr/></div>
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
             @php
                $partial = 0;
             @endphp
             @foreach ($data as $key => $order)
              @php
                $time = strtotime($order->created_at) + 60*60*4;
                $partial += $order->partial_amount;
              @endphp
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->company_name }} <!-- ({{ $order->account_no }}) --></td>
                <td>{{ ucfirst(str_replace("_", " ", $order->status)) }}</td>
                <td>
                <span class="gray" title="{{ ucfirst($order->plan_type) }}"><i class="fas {{ ($order->plan_type == 'mobile') ? 'fa-mobile-alt' : 'fa-phone-alt' }}"></i></span>&nbsp; {{($order->order_status_id == 23)? ($order->total_amount - $order->partial_amount): $order->total_amount }} </td>
                <td>{{ $order->fullname }}</td>
                <td>{{ date("Y-m-d H:i:s", $time) }}</td>
                <td>
                   <a class="btn" href="{{  route('order.show',$order->id) }}" title="View Orders"><i class="fas fa-eye"></i></a>
                  <a class="btn" href="mailto:himanshu@emperorcom.ae" title="Send Email"><i class="far fa-envelope"></i></a>
                  @can('order-edit')
                   <a class="btn" href="{{ route('order.edit',$order->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                  @endcan 
                  @can('order-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['order.destroy', $order->id],'style'=>'display:inline']) !!}
                    <button type="submit" class="btn" title="Delete" onclick="return confirmDel('{{ $order->company_name }}' );"><i class="fas fa-trash"></i></button>
                  {!! Form::close() !!}
                @endcan
                </td>
              </tr>
             @endforeach           
            </tbody>
            <tfoot>
            <tr>
               <th>OrderId</th>
               <th>Customer</th>
               <th>Status</th>
               <th>Total = <span class="text-danger">{{($totalamount - $partial)}}</span></th>
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

    let formData = new FormData($("#ord-search-frm")[0]), 
        data = {},       
        url = "{{ route('order.exportcsv') }}";

    formData.forEach((value, key) => {data[key] = value});
    let querystring = encodeQueryData(data),
        path = url+ '?' +querystring;


    window.location.href = path;
   // window.location.assign(path);

  });
});

function confirmDel(name){
  if(confirm('Are you sure to delete the order of '+name+' ?')){
    return true;
  }else{
    return false;
  }
}
</script>

@endsection