$(document).ready(function(){

/** add active class and stay opened when selected */
var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.nav-sidebar a').filter(function() {
    return this.href == url;
}).addClass('active');

// for treeview
$('ul.nav-treeview a').filter(function() {
    return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

  /****************** Data tables ***********************/
    $('#order-status-tbl').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#plan-tbl').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#pricing-tbl').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#roles-tbl').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#complaint-tbl').DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [[ 0, "desc" ]],
    });
    $('#order-tbl').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order": [[ 0, "desc" ]],
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#customer-tbl').DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [[ 0, "desc" ]],
    });

    $("#users-tbl").DataTable({
      "responsive": true,
      "autoWidth": false
    });

     $('#task-tbl').DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [[ 0, "desc" ]],
    });

    /****************** End Data tables ***********************/
  //Timepicker
   
        //Date range as a button
    $('#daterange-btn').daterangepicker(
      {  

        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },

      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        $('#start_date').val( start.format('YYYY-MM-DD'));
        $('#end_date').val( end.format('YYYY-MM-DD'));

      },
    );

    /******************************************************************/

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

    $('#fdatemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

    $('#reminder_date').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

        //Timepicker
    $('#datetimepicker').datetimepicker({
      format: 'LT'
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
      
    });

});

