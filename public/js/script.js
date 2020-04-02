$(document).ready(function(){
	/****************** Sidebar Menu ***********************/
	let url 	= window.location.pathname,
		aUrl 	= url.split('/'),
		len 	= aUrl.length,
		obj 	= $('#order-mu');
		len 	= len-1;

	if(aUrl[len] == 'order' || aUrl[len-1] == 'order'){
		obj.addClass('menu-open');
		obj.find('a').first().addClass('active');
	}else{
		obj.removeClass('menu-open');
		obj.find('a').first().removeClass('active');
	}

	/****************** End Sidebar ***********************/

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
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
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

    /****************** End Data tables ***********************/

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

});