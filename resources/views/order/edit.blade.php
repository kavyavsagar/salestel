@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Order</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('order.index') }}"> Back</a>
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

<form method="post" id="order_placed" enctype="multipart/form-data">
<input type="hidden" name="orderid" value="{{$order->id}}">
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab" href="#nav-customer" role="tab" aria-controls="nav-customer" aria-selected="true">Customer</a>
    @if ($order->plan_type == 'mobile')
    <a class="nav-item nav-link" id="nav-mobile-tab" data-toggle="tab" href="#nav-mobile" role="tab" aria-controls="nav-mobile" aria-selected="true">Mobile</a>
    @endif
    @if ($order->plan_type == 'fixed')
    <a class="nav-item nav-link" id="nav-fixed-tab" data-toggle="tab" href="#nav-fixed" role="tab" aria-controls="nav-fixed" aria-selected="false">Fixed</a>
    @endif
    <a class="nav-item nav-link" id="nav-status-tab" data-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <!-- CUSTOMER -->
    <div class="tab-pane fade show active" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
        <div class="row"><div class="col-xs-12 col-sm-12 col-md-12"><br></div></div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Customer:</strong>
                    <select class="form-control" name="customerid" id="customerid">   
                    <option value="0">-- None --</option>                
                    @foreach ($customerList as $key => $value)
                      <option value="{{ $key }}" {{ ($key == $customer->id) ? 'selected': ''}}> 
                        {{ $value }} 
                        </option>
                    @endforeach    
                </select>
                </div>
            </div> 
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Company Name:</strong>
                    {!! Form::text('company_name', $customer->company_name, array('placeholder' => 'Company Name','class' => 'form-control')) !!}
                </div>
            </div>    
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Location:</strong>
                    {!! Form::text('location', $customer->location, array('placeholder' => 'Location','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <strong class="text-uppercase">Authorized Person Details</strong>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Person Name:</strong>
                    {!! Form::text('authority_name', $customer->authority_name, array('placeholder' => 'Authority Name','class' => 'form-control')) !!}
                </div>
            </div>      
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('authority_email', $customer->authority_email, array('placeholder' => 'Authority Email','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Mobile</strong>
                    {!! Form::text('authority_phone', $customer->authority_phone, array('placeholder' => 'Authority Mobile','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <strong class="text-uppercase">Technical Person Details</strong>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Contact Name:</strong>
                    {!! Form::text('technical_name', $customer->technical_name, array('placeholder' => 'Technical Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('technical_email', $customer->technical_email, array('placeholder' => 'Technical Email','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Mobile</strong>
                    {!! Form::text('technical_phone', $customer->technical_phone, array('placeholder' => 'Technical Mobile','class' => 'form-control')) !!}
                </div>
            </div>  
        </div>
        <div class="row"> 
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                <strong>Reffered By:</strong>
                <select class="form-control" name="refferedby">   
                    <option value="0">-- Select --</option>                
                    @foreach ($users as $key => $value)
                      <option value="{{ $key }}" {{ ($key == $customer->refferedby)? 'selected': ''}}> 
                        {{ $value }} 
                      </option>
                    @endforeach    
                </select>            
                </div>
            </div>        
            <div class="col-xs-12 col-sm-6 col-md-6"> 
                <div class="form-group">
                    <strong>Upload all documents:</strong>
                    <input type="file" id="file-input" name="image[]" multiple="" placeholder="Choose documents" class="form-control">
                    <span class="text-danger">{{ $errors->first('image') }}</span>                   
                </div>        
            </div>
        </div>
        <div class="row">       
            <div class="col-xs-12 col-sm-12 col-md-12">
                @foreach ($documents as $key => $doc)
                <div id="{{$key}}" class="thumbimg">    
                   <img src="{{url($doc)}}" class="thumb">
                </div>
                @endforeach 
            </div>
        </div>
        <div class="row">       
            <div class="col-xs-12 col-sm-12 col-md-12"> <div id="thumb-output"></div></div>
        </div>
        <div class="row">       
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group float-right">
                    <button type="button" class="btn btn-primary btnNext" data-id="{{$order->plan_type}}">Continue</button>
                </div>
            </div>
        </div>
    </div>
   
    @if ($order->plan_type == 'mobile')
    <!--  MOBILE -->
    <div class="tab-pane fade show" id="nav-mobile" role="tabpanel" aria-labelledby="nav-mobile-tab">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div id="frmmobile">&nbsp;</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <select class="form-control" name="mobile_price" id="mprice"> 
                    <option value="">--MRC--</option>
                    @foreach ($mob_prices as $key => $value) 
                    <option value="{{ $value }}"> 
                        {{ $value }} 
                    </option>
                    @endforeach    
                </select>          
            </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <select class="form-control" name="mobile_plan" id="mplan"> 
                    <option value="">--PLANS--</option>
                    @foreach ($mob_plans as $key => $value) 
                    <option value="{{ $key }}-{{ $value }}"> 
                        {{ $value }} 
                    </option>
                    @endforeach    
                </select>
            </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-2">
                <div class="form-group">
                    <input type="number" name="mquantity" id="mqty" class="form-control" placeholder="Quantity"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="mobile-add">Add New</button>
                </div>
            </div>
        </div>   
        <table class="table table-striped" id="tbl-mob-plans">
              <thead>
                <tr>
                  <th scope="col">MRC</th>
                  <th scope="col">PLAN</th>
                  <th scope="col">QTY</th>
                  <th scope="col">TOTAL (AED)</th>
                  <th scope="col">ACTION</th>
                </tr>
              </thead>
              <tbody>                
                @foreach ($arplans as $key => $plan) 
                    <tr id="mrw-{{$key+1}}">
                        <th scope="row">{{$plan->price}}</th>
                        <td>{{$plan->plan}}</td>
                        <td>{{$plan->quantity}}</td>
                        <td>{{$plan->total}}</td>
                        <td><span id="inplan{{$key+1}}" class="d-none">{{ json_encode($plan) }}</span>
                            <a href="javascript:void(0);" class="del-mrow" data-id="{{$key+1}}">Delete</a>
                            <input type="hidden" id="order_mob_planid{{$key+1}}" value="{{$plan->order_planid}}">
                        </td>
                    </tr>
                @endforeach              
              </tbody>
        </table>
        <div class="row">       
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group float-right">
                    <button type="button" class="btn btn-secondary btnPrevious mr-1" data-id="customer">Previous</button>
                    <button type="button" class="btn btn-primary btnNext" data-id="status">Continue</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($order->plan_type == 'fixed')
    <!--  FIXED -->
    <div class="tab-pane fade" id="nav-fixed" role="tabpanel" aria-labelledby="nav-fixed-tab">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div id="frmfixed">&nbsp;</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <select class="form-control" name="fixed_price" id="fprice"> 
                    <option value="">--MRC--</option>
                    @foreach ($fxd_prices as $key => $value) 
                    <option value="{{ $value }}"> 
                        {{ $value }} 
                    </option>
                    @endforeach    
                </select>          
            </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <select class="form-control" name="fixed_plan" id="fplan"> 
                    <option value="">--PLANS--</option>
                    @foreach ($fxd_plans as $key => $value) 
                    <option value="{{ $key }}-{{ $value }}"> 
                        {{ $value }} 
                    </option>
                    @endforeach    
                </select>
            </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-2">
                <div class="form-group">
                    <input type="number" name="fquantity" id="fqty" class="form-control" placeholder="Quantity"/>                
                </div>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="fixed-add">Add New</button>
                </div>
            </div>
        </div>   
        <table class="table table-striped" id="tbl-fxd-plans">
              <thead>
                <tr>
                  <th scope="col">MRC</th>
                  <th scope="col">PLAN</th>
                  <th scope="col">QTY</th>
                  <th scope="col">TOTAL (AED)</th>
                  <th scope="col">ACTION</th>
                </tr>
              </thead>
              <tbody>               
                @foreach ($arplans as $key => $plan) 
                    <tr id="frw-{{$key+1}}">
                        <th scope="row">{{$plan->price}}</th>
                        <td>{{$plan->plan}}</td>
                        <td>{{$plan->quantity}}</td>
                        <td>{{$plan->total}}</td>
                        <td><span id="finplan{{$key+1}}" class="d-none">{{ json_encode($plan) }}</span>
                            <a href="javascript:void(0);" class="del-frow" data-id="{{$key+1}}">Delete</a>
                            <input type="hidden" id="order_fxd_planid{{$key+1}}" value="{{$plan->order_planid}}">
                        </td>
                    </tr>
                @endforeach            
              </tbody>
        </table>
        <div class="row">       
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group float-right">
                    <button type="button" class="btn btn-secondary btnPrevious mr-1" data-id="customer">Previous</button>
                    <button type="button" class="btn btn-primary btnNext" data-id="status">Continue</button>
                </div>
            </div>
        </div>
    </div>
    @endif      

    <!-- Status -->
    <div class="tab-pane fade" id="nav-status" role="tabpanel" aria-labelledby="nav-status-tab">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div id="frmstatus">&nbsp;</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <select class="form-control" name="order_status" id="ostatus">                 
                    @foreach ($ordstatus as $key => $value) 
                    <option value="{{ $key }}" {{ ($key == $order->order_status_id)? 'selected' : ''}}> 
                        {{ ucwords(str_replace("_"," ",$value)) }} 
                    </option>
                    @endforeach    
                </select>          
            </div>
            </div>   
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <textarea name="comments" id="comments" class="form-control" placeholder="Enter comments"></textarea>
                </div>
            </div>           
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <input type="text" name="activity_no" id="activity_no" class="form-control" placeholder="Enter Activity Number"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                      <th scope="col">Status</th>
                      <th scope="col">Comments</th>
                      <th scope="col">Activity No</th>
                      <th scope="col">Added By</th>
                      <th scope="col">Date Added</th>
                    </tr>
                    </thead>
                    <tbody>  
                    @foreach ($history as $key => $hist)
                    <tr>
                        <th scope="row">{{ucwords(str_replace("_"," ",$hist->name))}} </th>
                        <td>{{$hist->comments}}</td>
                        <td>{{$hist->activity_no}}</td>
                        <td>{{$hist->fullname}}</td>
                        <td>{{date("d/m/Y", strtotime($hist->created_at))}}</td>
                    </tr>
                    @endforeach                    
                    </tbody>
                </table> 
            </div>
        </div>   
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group float-right">
                    <button type="button" class="btn btn-secondary btnPrevious mr-1" data-id="{{$order->plan_type}}">Previous</button>
                    <button type="submit" class="btn btn-primary btn-submit">Confirm & Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<script type="text/javascript">    
$(document).ready(function(){

    // ***************** MOBILE ***************** //
    var rowCounter = $('#tbl-mob-plans tbody tr').length;

    $('#mobile-add').on('click', function(e){ //on file input change
        e.preventDefault();   

        if(!$('#mprice').val()){           
            $("#frmmobile").addClass('alert alert-danger').text("Please select the MRC!");
            return false;
        }
        if(!$('#mplan').val()){            
            $("#frmmobile").addClass('alert alert-danger').text("Please select the plan!");
            return false;
        }
        if(!$('#mqty').val()){            
            $("#frmmobile").addClass('alert alert-danger').text("Please enter the quantity!");
            return false;
        }

        rowCounter++;

        let price = parseInt($('#mprice').val()),
            splan = $('#mplan').val(),
            qty = parseInt($('#mqty').val()),
            total = parseInt(price * qty),
            plan = splan.split("-");    

        let mobd = JSON.stringify({"price": price, "planid": parseInt(plan[0]), "plan": plan[1], "qty": qty, "total": total});        

        let tblrow = '<tr id="mrw-'+rowCounter+'"><th scope="row">'+ price +'</th><td>'+ plan[1] +'</td><td>'+ qty +'</td><td>'+total +'</td><td><span id="inplan'+rowCounter+'" class="d-none">'+mobd+'</span><a href="javascript:void(0);" class="del-mrow" data-id="'+rowCounter+'">Delete</a></td></tr>';

        if(price && plan &&  qty){
            $('#tbl-mob-plans tbody').append(tblrow);     
        }
    }); 

    // delete row
    jQuery(document).delegate('a.del-mrow', 'click', function(e) {
        e.preventDefault();

        let rid = jQuery(this).attr('data-id');      
            rid = parseInt(rid); 

        if($('#order_mob_planid'+rid).val()){
            jQuery('#mrw-'+rid).addClass('d-none');
            let parse = jQuery(this).closest('td').find('span#inplan'+rid).html();
            
            parse = JSON.parse(parse);
            parse.isdelete = 1;
            jQuery(this).closest('td').find('span#inplan'+rid).html(JSON.stringify(parse));

        }else{
            jQuery('#mrw-'+rid).remove();
        }

        //rowCounter--;
    });
    /***********************************************/


    // ***************** FIXED ***************** //
    var rowFCounter = $('#tbl-fxd-plans tbody tr').length;

    $('#fixed-add').on('click', function(e){ //on file input change
        e.preventDefault();   

        if(!$('#fprice').val()){           
            $("#frmfixed").addClass('alert alert-danger').text("Please select the MRC!");
            return false;
        }
        if(!$('#fplan').val()){            
            $("#frmfixed").addClass('alert alert-danger').text("Please select the plan!");
            return false;
        }
        if(!$('#fqty').val()){            
            $("#frmfixed").addClass('alert alert-danger').text("Please enter the quantity!");
            return false;
        }

        rowFCounter++;

        let price = parseInt($('#fprice').val()),
            splan = $('#fplan').val(),
            qty = parseInt($('#fqty').val()),
            total = parseInt(price * qty),
            plan = splan.split("-");    

        let fixd = JSON.stringify({"price": price, "planid": parseInt(plan[0]), "plan": plan[1], "qty": qty, "total": total});        

        let tblrow = '<tr id="frw-'+rowFCounter+'"><th scope="row">'+ price +'</th><td>'+ plan[1] +'</td><td>'+ qty +'</td><td>'+total +'</td><td><span id="finplan'+rowFCounter+'" class="d-none">'+fixd+'</span><a href="javascript:void(0);" class="del-frow" data-id="'+rowFCounter+'">Delete</a></td></tr>';

        if(price && plan &&  qty){
            $('#tbl-fxd-plans tbody').append(tblrow);     
        }
    }); 
    
    // delete row
    jQuery(document).delegate('a.del-frow', 'click', function(e) {
        e.preventDefault();    

        let rid = jQuery(this).attr('data-id');
        rid = parseInt(rid);

        if($('#order_fxd_planid'+rid).val()){
            jQuery('#frw-'+rid).addClass('d-none');
            let parse = jQuery(this).closest('td').find('span#finplan'+rid).html();
            
            parse = JSON.parse(parse);
            parse.isdelete = 1;
            jQuery(this).closest('td').find('span#finplan'+rid).html(JSON.stringify(parse));

        }else{
            jQuery('#frw-'+rid).remove();
        }        
        //rowFCounter--;
    });


    /***********************************************/

    $('.btnNext').on('click', function (e) {
        e.preventDefault();
        let next = $(this).attr('data-id');
        $('#nav-tab a[href="#nav-'+next+'"]').tab('show');       
    });

    $('.btnPrevious').on('click', function (e) {
        e.preventDefault();
        let next = $(this).attr('data-id');
        $('#nav-tab a[href="#nav-'+next+'"]').tab('show');       
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /********************** LOAD CUSTOMER *****************************/
    $('#customerid').on('change', function(e){ 
        let cid = parseInt($(this).val());   

        if(cid != 0){
            $.get("{{ url('ajxcustomer') }}"+'/'+cid, function(data, status){
                if(data){
                    let cust = JSON.parse(data.customer);
                    $("#order_placed input[name=company_name]").val(cust.company_name);
                    $("#order_placed input[name=location]").val(cust.location);
                    $("#order_placed input[name=authority_name]").val(cust.authority_name);
                    $("#order_placed input[name=authority_email]").val(cust.authority_email);
                    $("#order_placed input[name=authority_phone]").val(cust.authority_phone);
                    $("#order_placed input[name=technical_name]").val(cust.technical_name);
                    $("#order_placed input[name=technical_email]").val(cust.technical_email);
                    $("#order_placed input[name=technical_phone]").val(cust.technical_phone);
                    $("#order_placed select[name=refferedby]").val(cust.refferedby);
                    
                }
            });            
        }else{
            $("#order_placed").trigger("reset");
        }
    });

    /********************* POST FORM **************************/
    $('#order_placed').on('submit', function(e){ 
        e.preventDefault();

        var mobData = [], 
            fxdData =[];
        
        $('#tbl-mob-plans tbody').find('tr').each(function() {            
            let rwid = $(this).attr('id');
                rwid = rwid.split('-'),
                parse = JSON.parse($(this).find('span#inplan'+rwid[1]).html());

            mobData.push(parse);
            //console.log(mobData);
        });

        $('#tbl-fxd-plans tbody').find('tr').each(function() {            
            let rwid = $(this).attr('id');
                rwid = rwid.split('-'),
                parse = JSON.parse($(this).find('span#finplan'+rwid[1]).html());

            fxdData.push(parse);
            //console.log(fxdData);
        });

        let formData = new FormData($("#order_placed")[0]);
            formData.append('mobile', JSON.stringify(mobData));
            formData.append('fixed', JSON.stringify(fxdData));

        $.ajax({
            type:'POST',
            url:"{{ route('order.updateOrder') }}",
            data: formData,  
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,        
            success:function(data){
              if(data.success){
                alert(data.success);                
                window.location.href = "{{ route('order.index') }}";
              }
            },
            error:function(data){
              alert(data.errors);
              return;
            }
        });
  
    });

    /************* File Upload *************************/
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