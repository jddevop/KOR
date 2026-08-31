<script src="{{ asset('asset/admin/plugins/components/jquery/dist/jquery.min.js') }}"></script>
<!-- ===== Bootstrap JavaScript ===== -->
<script src="{{ asset('asset/admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- ===== Slimscroll JavaScript ===== -->
<script src="{{ asset('asset/admin/js/jquery.slimscroll.js') }}"></script>
<!-- ===== Wave Effects JavaScript ===== -->
<script src="{{ asset('asset/admin/js/waves.js') }}"></script>
<!-- ===== Menu Plugin JavaScript ===== -->
<script src="{{ asset('asset/admin/js/sidebarmenu.js') }}"></script>
<!-- ===== Custom JavaScript ===== -->
<script src="{{ asset('asset/admin/js/custom.js') }}"></script>
<!-- ===== Plugin JS ===== -->
<script src="{{ asset('asset/admin/plugins/components/chartist-js/dist/chartist.min.js') }}"></script>
<script src="{{ asset('asset/admin/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('asset/admin/plugins/components/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('asset/admin/plugins/components/sparkline/jquery.charts-sparkline.js') }}"></script>
<script src="{{ asset('asset/admin/plugins/components/knob/jquery.knob.js') }}"></script>
<script src="{{ asset('asset/admin/plugins/components/easypiechart/dist/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('asset/admin/js/db1.js') }}"></script>
<!-- ===== Style Switcher JS ===== -->
<script src="{{ asset('asset/admin/plugins/components/styleswitcher/jQuery.style.switcher.js') }}"></script>


<script type="text/javascript">
 $.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')
	}
});
$(document).on('change', '.changestatus', function () {
	var table = $(this).attr('data-table');
	var id = $(this).attr('data-id');
	var field_name = $(this).attr('data-field');
	var id_name = $(this).attr('data-id-name');
	var status = 0;
	if ($(this).is(":checked"))
	{
		status = 1;
	}
	
	jQuery.ajax( {
		type: "POST",
		url: "{{ route('admin.changestatus') }}",
		dataType: 'json',
		data: {"table": table,"id":id ,"status": status,"field_name":field_name,"id_name":id_name,},
		async: false,
		success: function(response) {
			if(response.success==1)
			{
				var msg='<div class="alert alert-success" role="alert" id="myDiv"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="mdi mdi-block-helper"></i> Status update successfully.</div>';
				$('#errormsg').html(msg);
			}
		}
	});
});
</script>

<script>
    function fetchNotifications() {
        $.ajax({
            url: "{{ route('admin.get_notification') }}",
            type: "POST",
            dataType: "json",
            success: function(data) {
                if(data.status==1)
                {
                    if(data.noti_count > 0)
                    {
                        var c='<span class="badge badge-xs badge-danger">'+data.noti_count+'</span>'
                        $('#show_noti').html(c);
                        $('#show_noti_list').html(data.html_data);
                    }else{
                        $('#show_noti').html('');
                        $('#show_noti_list').html(data.html_data);
                    }
                }
            },
            error: function(error) {
                
            }
        });
    }

    setInterval(fetchNotifications, 10000);

    $(document).ready(function() {
        fetchNotifications();
    });
</script>

