@extends('layouts.app')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Create DSR</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('dsr.index') }}">DSR</a></li>
          <li class="breadcrumb-item active">Create DSR</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    @if (count($errors) > 0)
        <div class="row">
            <div class="col">
                <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                   @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                   @endforeach
                </ul>
                </div>
            </div>
        </div>
    @endif
 
    <form method="post" id="order_placed" autocomplete="off">
      <div class="row">
        <!-- left column -->
        
        <div class="col-4">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Customer</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <input type="hidden" name="refferedby" value="{{Auth::id()}}">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Company Name:</label>
                            {!! Form::text('company', null, array('placeholder' => 'Company Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Person Name:</label>
                            {!! Form::text('contact_name', null, array('placeholder' => 'Contact Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Email:</label>
                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Mobile</label>
                            {!! Form::text('phone', null, array('placeholder' => 'Phone','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Location:</label>
                            {!! Form::text('location', null, array('placeholder' => 'Location','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" name="dsr_status" id="dsr_status">                                                           
                                @foreach ($dsrStatus as $key => $value)
                                  <option value="{{ $key }}"> 
                                    {{ ucwords($value) }} 
                                  </option>
                                @endforeach 
                            </select> 
                        </div>                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                         <div class="form-group">
                            <label>Remarks:</label>
                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter comments"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <!-- Date dd/mm/yyyy -->
                        <div class="form-group">
                            <label>Reminder Date Time:</label>
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="reminder_date"/>
                               
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   <!--  <div class="col-xs-12 col-sm-6 col-md-6"></div> -->
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Expected Amount:</label>
                            {!! Form::text('expected_amount', null, array('placeholder' => 'Expected Closing Amount','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <label>Expected Closing Date:</label>
                        <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" name="expected_closing"/>
                           
                            <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                            </div>
                        </div>                     
                    </div>
                </div>
              </div>
              <div class="card-footer">
                 <!--  <a class="btn btn-default float-right" href="{{ route('dsr.index') }}"> Back</a> -->
              </div> 
            </div>
            <!-- /.card -->
        </div>

        <div class="col-8">
      
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Plan Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="price" id="mprice" class="form-control" placeholder="MRC"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">                           
                            <div class="form-group">
                                <input type="text" name="plan" id="mplan" class="form-control" placeholder="Plan"> 
                            </div>
                        </div>                    
                        <div class="col-xs-12 col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" name="quantity" id="mqty" class="form-control" placeholder="Quantity" value="1"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                            <select class="form-control" name="plan_type" id="mptype"> 
                                <option value="mobile">Mobile</option>
                                <option value="fixed">Fixed</option>                                  
                            </select>
                            </div>
                        </div>                        
                        <div class="col-xs-12 col-sm-1 col-md-1">
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" id="mobile-add">Add</button>
                            </div>
                        </div>
                </div>   
                <div class="table-responsive p-0">
                <table class="table table-striped table-hover text-nowrap" id="tbl-mob-plans">
                      <thead>
                        <tr>
                          <th scope="col">MRC</th>
                          <th scope="col">PLAN</th>                         
                          <th scope="col">Plan Type</th>
                          <th scope="col">QTY</th>
                          <th scope="col">TOTAL (AED)</th>
                          <th scope="col">ACTION</th>
                        </tr>
                      </thead>
                      <tbody>                
                      </tbody>
                </table>
                </div>
              </div>
            <div class="card-footer">
                <a class="btn btn-default" href="{{ route('dsr.index') }}"> Back</a>
                <button type="submit" class="btn btn-primary btn-submit  float-right">Submit</button>
                <div id="loader"></div>
            </div>    
            </div>
            <!-- /.card -->
           
        </div>
    
      </div>
    </form>
    </div>
</section>

<script type="text/javascript">    
$(document).ready(function(){

    // ***************** MOBILE ***************** //
    var rowCounter = 0;
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
            plan = $('#mplan').val(),
            ptype = $('#mptype').val(),
            qty = parseInt($('#mqty').val()),
            total =  parseInt(price * qty);

        let mobd = JSON.stringify({"price": price, "plan": plan, "plan_type": ptype, "qty": qty, "total": total});        

        let tblrow = '<tr id="mrw-'+rowCounter+'"><th scope="row">'+ price +'</th><td>'+ plan +'</td><td>'+ ptype +'</td><td>'+ qty +'</td><td>'+total +'</td><td><span id="inplan'+rowCounter+'" class="d-none">'+mobd+'</span><a href="javascript:void(0);" class="del-mrow" data-id="'+rowCounter+'" title="Delete"><i class="fas fa-trash"></i></a></td></tr>';

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
   

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

        if(loading){
            $('#loader').html('Please wait it will take few seconds to complete...');
        }

        let formData = new FormData($("#order_placed")[0]);
            formData.append('plandetails', JSON.stringify(mobData));

        $.ajax({
            type:'POST',
            url:"{{ route('dsr.store') }}",
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
                    window.location.href = "{{ route('dsr.index') }}";
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

    $('#datetimepicker1').datetimepicker();

    $('#datetimepicker2').datetimepicker({
            format: 'L'
        });

    // $('#dsr_status').on('change', function(){
    //     let status = $(this).val();
    //     if(status == 'callback' || status == 'appointment'){
    //         $('#reminder').removeClass('d-none');
    //     }else{
    //         $('#reminder').addClass('d-none');
    //     }
    // });


});

</script>
@endsection
