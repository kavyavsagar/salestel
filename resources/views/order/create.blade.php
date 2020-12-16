@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Place an Order</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
          <li class="breadcrumb-item active">Place an Order</li>
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
        <div class="card card-primary card-outline card-outline-tabs">     
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="nav-customer-tab" data-toggle="pill" href="#nav-customer" role="tab" aria-controls="nav-customer" aria-selected="true">Customer</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="nav-mobile-tab" data-toggle="pill" href="#nav-mobile" role="tab" aria-controls="nav-mobile" aria-selected="false">Mobile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link"  id="nav-fixed-tab" data-toggle="pill" href="#nav-fixed" role="tab" aria-controls=""" aria-selected="false">Fixed</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="nav-status-tab" data-toggle="pill" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>
            </ul>
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
            <!-- form start -->   
            <form method="post" id="order_placed" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="customerid" id="customerid" class="form-control input-lg"/>
            <div class="tab-content" id="nav-tabContent">
                <!-- CUSTOMER -->
                <div class="tab-pane fade show active" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
                    <div class="row"><div class="col-xs-12 col-sm-12 col-md-12"><br></div></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Customer (existing):</label>
                                <input type="text" name="customerext" id="customerext" class="form-control input-lg" placeholder="Company / Account No" />
                                <div id="companyList"></div>                 
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Company Name: <span class="help-block">*</span></label>
                                {!! Form::text('company_name', null, array('placeholder' => 'Company Name','class' => 'form-control')) !!}
                            </div>
                        </div>                         
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Account Number: <span class="help-block">*</span></label>
                                {!! Form::text('account_no', null, array('placeholder' => 'Account No.','class' => 'form-control')) !!}
                            </div>
                        </div>    
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Location: <span class="help-block">*</span></label>
                                {!! Form::text('location', null, array('placeholder' => 'Location','class' => 'form-control')) !!}
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
                                <label>Person Name: <span class="help-block">*</span></label>
                                {!! Form::text('authority_name', null, array('placeholder' => 'Authority Name','class' => 'form-control')) !!}
                            </div>
                        </div>      
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Email: <span class="help-block">*</span></label>
                                {!! Form::text('authority_email', null, array('placeholder' => 'Authority Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Mobile <span class="help-block">*</span></label>
                                {!! Form::text('authority_phone', null, array('placeholder' => 'Authority Mobile','class' => 'form-control')) !!}
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
                                <label>Contact Name: <span class="help-block">*</span></label>
                                {!! Form::text('technical_name', null, array('placeholder' => 'Technical Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Email: <span class="help-block">*</span></label>
                                {!! Form::text('technical_email', null, array('placeholder' => 'Technical Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Mobile <span class="help-block">*</span></label>
                                {!! Form::text('technical_phone', null, array('placeholder' => 'Technical Mobile','class' => 'form-control')) !!}
                            </div>
                        </div>  
                    </div>
                    <div class="row">         
                        <div class="col-xs-12 col-sm-6 col-md-6"> 
                            <div class="form-group">
                                <label>Upload all documents: </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file-input" name="image[]" multiple
                                        accept="image/jpeg,image/jpg,image/png,image/bmp,application/pdf" />
                                        <label class="custom-file-label" for="file-input">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                                <p class="small text-muted mt-1">documents should be in this formats (jpeg, png, jpg, bmp, pdf)</p>
                                <div id="file-error" class="text-danger mt-1"></div>
                                <span class="text-danger">{{ $errors->first('image') }}</span>           
                            </div>

                            <div id="file_div">
                               <div>
                                <input type="file" name="file[]">
                                <input type="button" id="add_file" value="ADD MORE">
                               </div>
                              </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                        @hasanyrole('Coordinator|Admin')
                            <div class="form-group">
                            <label>Reffered By:</label>
                            <select class="form-control" name="refferedby">   
                                <option value="0">-- Select --</option>                
                                @foreach ($users as $key => $value)
                                  <option value="{{ $key }}"> 
                                    {{ $value }} 
                                  </option>
                                @endforeach    
                            </select>            
                            </div>
                        @else
                          <input type="hidden" name="refferedby" value="{{Auth::id()}}">
                        @endhasanyrole 
                        </div>
                    </div>
                    <div class="row">       
                        <div class="col-xs-12 col-sm-12 col-md-12"> <div id="thumb-output"></div></div>
                    </div>
                    <div class="row">       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-outline-primary btnNext" data-id="mobile">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  MOBILE -->
                <div class="tab-pane fade show" id="nav-mobile" role="tabpanel" aria-labelledby="nav-mobile-tab">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div id="frmmobile">&nbsp;</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2">
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
                        <div class="col-xs-12 col-sm-2 col-md-2">
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
                            <select class="form-control" name="plan_type" id="mptype"> 
                                <option value="">--PLAN TYPE--</option>
                                @foreach ($planStatus as $key => $value) 
                                <option value="{{ $key }}"> 
                                    {{ $value }} 
                                </option>
                                @endforeach  
                              <!--   <option value="New">New</option>
                                <option value="MNP">MNP</option>
                                <option value="Migrated">Migrated</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Upgrade">Upgrade</option>
                                <option value="Downgrade">Downgrade</option>
                                <option value="Cancel">Cancel</option>
                                <option value="Vas">Vas</option>
                                <option value="RPC">RPC - Rate Plan Change</option> -->
                            </select>          
                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" name="mquantity" id="mqty" class="form-control" placeholder="Quantity" 
                                value="0"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <div class="form-group">
                                <textarea name="phoneno" id="phoneno" class="form-control" placeholder="Phone Nos"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="mobile-add">Add</button>
                            </div>
                        </div>
                    </div>   
                    <div class="table-responsive p-0">
                    <table class="table table-striped table-hover text-nowrap" id="tbl-mob-plans">
                          <thead>
                            <tr>
                              <th scope="col">MRC</th>
                              <th scope="col">PLAN</th>
                              <th scope="col">Type</th>
                              <th scope="col">Phone Nos.</th>
                              <th scope="col">QTY</th>
                              <th scope="col">TOTAL (AED)</th>
                              <th scope="col">ACTION</th>
                            </tr>
                          </thead>
                          <tbody>                
                          </tbody>
                    </table>
                    </div>
                    <div class="row">       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-outline-secondary btnPrevious mr-1" data-id="customer">Previous</button>
                                <button type="button" class="btn btn-outline-primary btnNext" data-id="fixed">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  FIXED -->
                <div class="tab-pane fade" id="nav-fixed" role="tabpanel" aria-labelledby="nav-fixed-tab">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div id="frmfixed">&nbsp;</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2">
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
                        <div class="col-xs-12 col-sm-3 col-md-3">
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
                            <select class="form-control" name="fixed_type" id="fptype"> 
                                <option value="">--PLAN TYPE--</option>
                                @foreach ($planStatus as $key => $value) 
                                <option value="{{ $key }}"> 
                                    {{ $value }} 
                                </option>
                                @endforeach  
                                <!-- <option value="New">New</option>
                                <option value="MNP">MNP</option>
                                <option value="Migrated">Migrated</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Upgrade">Upgrade</option>
                                <option value="Downgrade">Downgrade</option>
                                <option value="Cancel">Cancel</option>
                                <option value="Vas">Vas</option>
                                <option value="RPC">RPC - Rate Plan Change</option> -->
                            </select>          
                        </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" name="fquantity" id="fqty" class="form-control" placeholder="Quantity" value="0"/>                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="fixed-add">Add</button>
                            </div>
                        </div>
                    </div>   
                    <div class="table-responsive p-0">
                    <table class="table table-striped table-hover text-nowrap" id="tbl-fxd-plans">
                          <thead>
                            <tr>
                              <th scope="col">MRC</th>
                              <th scope="col">PLAN</th>
                              <th scope="col">Type</th>
                              <th scope="col">QTY</th>
                              <th scope="col">TOTAL (AED)</th>
                              <th scope="col">ACTION</th>
                            </tr>
                          </thead>
                          <tbody>                
                          </tbody>
                    </table>
                    </div>
                    <div class="row">       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-outline-secondary btnPrevious mr-1" data-id="mobile">Previous</button>
                                <button type="button" class="btn btn-outline-primary btnNext" data-id="status">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-status" role="tabpanel" aria-labelledby="nav-status-tab">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div id="frmstatus">&nbsp;</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="order_status" id="ostatus">                 
                                @foreach ($ordstatus as $key => $value) 
                                <option value="{{ $key }}"> 
                                    {{ ucwords(str_replace("_"," ",$value)) }} 
                                </option>
                                @endforeach    
                            </select>          
                        </div>
                        </div>   
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <textarea name="comments" id="comments" class="form-control" placeholder="Enter comments"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <!-- <div class="form-group">
                                <input type="text" name="leadno" id="leadno" class="form-control" placeholder="Lead No"/>                
                            </div> -->
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-outline-secondary btnPrevious mr-1" data-id="fixed">Previous</button>
                                <button type="submit" class="btn btn-outline-success btn-submit">Confirm & Save</button>
                                <div id="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>           
          </div>
            <!-- /.card-body -->
          <div class="card-footer">
              <a class="btn btn-secondary float-right" href="{{ route('order.index') }}"> Back</a>
          </div>          
        </div>
        <!-- /.card -->
    </div>
    
    </div>
    </div>
</section>




<script type="text/javascript">    
$(document).ready(function(){

    $('#add_file').on('click', function(e){
        e.preventDefault();   

        $("#file_div").append("<div><input type='file' name='file[]'><input type='button' value='REMOVE' id='remove_file'></div>");
    });
    $('#remove_file').on('click', function(e){
        e.preventDefault();   

        $(e).parent().remove();
    });
  
    // ***************** MOBILE ***************** //
    var rowCounter = 0;
    $('#mobile-add').on('click', function(e){ //on file input change
        e.preventDefault();   

        if(!$('#mprice').val()){           
            $("#frmmobile").addClass('alert alert-danger').text("Please select the MRC!");
            return false;
        }
        if(!$('#mptype').val()){           
            $("#frmmobile").addClass('alert alert-danger').text("Please select the Plan Type!");
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
            ptype = $('#mptype').val(),
            phoneno = $('#phoneno').val(),
            qty = parseInt($('#mqty').val()),
            total =  parseInt(price * qty),
            plan = splan.split("-"); 

        if(ptype == 'Upgrade' || ptype == 'Downgrade' || ptype == 'Vas' || ptype == 'RPC'){
            qty = total = 0;
        }else if(ptype == 'Cancel'){
            qty =  qty < 0 ? qty : (qty > 0 ? (qty * -1) : -1);
            total = parseInt(price * qty);
        }

        let mobd = JSON.stringify({"price": price, "planid": parseInt(plan[0]), "plan": plan[1], "plan_type": ptype, "phoneno": phoneno, "qty": qty, "total": total});        

        let tblrow = '<tr id="mrw-'+rowCounter+'"><th scope="row">'+ price +'</th><td>'+ plan[1] +'</td><td>'+ ptype +'</td><td>'+ phoneno +'</td><td>'+ qty +'</td><td>'+total +'</td><td><span id="inplan'+rowCounter+'" class="d-none">'+mobd+'</span><a href="javascript:void(0);" class="del-mrow" data-id="'+rowCounter+'" title="Delete"><i class="fas fa-trash"></i></a></td></tr>';

        if(price && plan && ptype){
            $('#tbl-mob-plans tbody').append(tblrow);     
        }
    }); 

    // delete row
    jQuery(document).delegate('a.del-mrow', 'click', function(e) {
        e.preventDefault();    

        let rid = jQuery(this).attr('data-id');      
        rid = parseInt(rid);
        jQuery('#mrw-'+rid).remove();
        //rowCounter--;
    });
    /***********************************************/


    // ***************** FIXED ***************** //
    var rowFCounter = 0;
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
        if(!$('#fptype').val()){            
            $("#frmfixed").addClass('alert alert-danger').text("Please select the plan type!");
            return false;
        }    
        if(!$('#fqty').val()){            
            $("#frmfixed").addClass('alert alert-danger').text("Please enter the quantity!");
            return false;
        }

        rowFCounter++;

        let price = parseInt($('#fprice').val()),
            splan = $('#fplan').val(),
            fptype = $('#fptype').val(),
            qty = parseInt($('#fqty').val()),
            total = parseInt(price * qty),
            plan = splan.split("-");  

        if(fptype == 'Upgrade' || fptype == 'Downgrade' || fptype == 'Vas' || fptype == 'RPC'){
            qty = total = 0;        
        }else if(fptype == 'Cancel'){
            qty =  qty < 0 ? qty : (qty > 0 ? (qty * -1) : -1);
            total = parseInt(price * qty);
        }

        let fixd = JSON.stringify({"price": price, "planid": parseInt(plan[0]), "plan": plan[1], "plan_type": fptype, "qty": qty, "total": total});        

        let tblrow = '<tr id="frw-'+rowFCounter+'"><th scope="row">'+ price +'</th><td>'+ plan[1] +'</td><td>'+ fptype +'</td><td>'+ qty +'</td><td>'+total +'</td><td><span id="finplan'+rowFCounter+'" class="d-none">'+fixd+'</span><a href="javascript:void(0);" class="del-frow" data-id="'+rowFCounter+'" title="Delete"><i class="fas fa-trash"></i></a></td></tr>';

        if(price && plan && fptype){
            $('#tbl-fxd-plans tbody').append(tblrow);     
        }
    }); 
    
    // delete row
    jQuery(document).delegate('a.del-frow', 'click', function(e) {
        e.preventDefault();    

        let rid = jQuery(this).attr('data-id');
        rid = parseInt(rid);
        jQuery('#frw-'+rid).remove();
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
    const customerDetails = function(cid){       
        if(cid != 0){ 
            $.get("{{ url('ajxcustomer') }}"+'/'+cid, function(data, status){               
                if(data){                 
                    let cust = JSON.parse(data.customer);
                    $("#order_placed input[name=customerid]").val(cust.id);
                    $("#order_placed input[name=company_name]").val(cust.company_name);
                    $("#order_placed input[name=account_no]").val(cust.account_no);
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
    };

    /********************* POST FORM **************************/
    var loading = false;
    $('#order_placed').on('submit', function(e){ 
        e.preventDefault();
        loading = true;

        var mobData = [], 
            fxdData =[];
        
        $('#tbl-mob-plans tbody').find('tr').each(function() {            
            let rwid = $(this).attr('id');
                rwid = rwid.split('-'),
                parse = JSON.parse($(this).find('span#inplan'+rwid[1]).html());

            mobData.push(parse);
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

        if(loading){
            $('#loader').html('Please wait it will take few seconds to complete...');
        }

        $.ajax({
            type:'POST',
            url:"{{ route('order.store') }}",
            data: formData,  
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,        
            success:function(data){
              if(data.success){
                loading = false;
                $('#loader').html('');
                toastr.success(data.success); 

                setTimeout(function(){
                    window.location.href = "{{ route('order.index') }}";
                }, 1200);

              }
            },
            error:function(data){   
                let err_str = '';  

                if(data.responseJSON.errors){
                    loading = false;
                    $('#loader').html('');
                    err_str = '<dl class="row">';  
                    $.each(data.responseJSON.errors, function(key, val){
                        err_str += '<dt class="col-sm-4">'+key.replace("_", " ")+ ' </dt><dd class="col-sm-8">'+ val+ '</dd>';
                    });
                    err_str += '</dl>';  
                    toastr.error(err_str);  
                    return;
                }
                
            }
        });
  
    });

    /************* File Upload *************************/
    $('#file-input').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
             
            var data = $(this)[0].files; //this file data
            $.each(data, function(index, file){ //loop though each file
               if(/(\.|\/)(bmp|jpe?g|png)$/i.test(file.type) || file.type.match('application/pdf')){ 
                    //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                        return function(e) {                           
                            let preview = '';
                            if(file.type.match('application/pdf')){
                                preview = $('<p/>').addClass('text-danger m-1').html(file.name);
                            }else{
                                preview = $('<img/>').addClass('img-fluid img-thumbnail m-1 mht-100').attr('src', e.target.result); //create image element 
                            }
                            
                            $('#thumb-output').append(preview); //append image to output element
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                    $('#file-error').html("");
                }else{                        
                    $('#file-error').html("Selected file extension not allowed");
                    return;
                }; 
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
    /************************* L ********************************/
    // $('#customerext').keyup(function(){ 
    //     var query = $(this).val();
    //     if(query != '')
    //     {
    //     // var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url:"{{ route('customer.fetch') }}",
    //         method:"POST",
    //         data:{query:query}, //, _token:_token
    //         success:function(data){
    //           $('#companyList').fadeIn();  
    //           $('#companyList').html(data);
    //         }
    //     });
    //     }
    // });

    var fnajx = function(value){ 
        var query = value;      
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
    };
    $( "#customerext" ).on({
        keyup: function() {
            console.log( "keyup over a div" );
            let v = $(this).val();
            fnajx(v);
        },
        paste: function(e) {
            console.log( "paste left a div" );
            var clipboardData = e.clipboardData || e.originalEvent.clipboardData || window.clipboardData;
            var pastedData = clipboardData.getData('text');
            fnajx(pastedData);
        }
    });

    $(document).on('click', '#companyList > ul > li', function(){  
        let str = $(this).text();
        $('#customerext').val(str);        
        $('#companyList').fadeOut(); 

        let ar = str.split(" | "),
        arg = ar[1]? ar[1] : ar[0];
      
        customerDetails(arg);

    });  

});

</script>
@endsection