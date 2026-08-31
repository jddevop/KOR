@php($i=1)
@foreach($view_data as $data)
<tr>
<td>
    <input type="checkbox" class="check">
</td>
<td>{{ $data->name }}</td>
<td>{{ $data->address }}</td>
<td>{{ number_format($data->payment_rate, 2) }}</td>
<td>{{ date("d-m-Y",strtotime($data->start_date)) }}</td>
<td>{{ date("d-m-Y",strtotime($data->end_date)) }}</td>
<td>
    <?php $count_con=get_event_status_count($data->id); if($count_con < $data['total_staff_required']){ ?>
        <span class="label label-danger"><?php echo $count_con;?> / <?php echo $data['total_staff_required']; ?></span>
    <?php }else{
    ?>
    <span class="label label-success"><?php echo $count_con;?> / <?php echo $data['total_staff_required']; ?></span>
    <?php
    }?>
</td>
<td><a href="<?php echo $data->whatsapp_group_link; ?>" target="_blank" > <img src="{{ asset('asset/admin/images/whatsap.png') }}" alt="loader"/></a></td>
<td>@php($status_chk='')
@if ($data->event_status == 1)
	@php($status_chk='checked="checked"')
@endif
	<div class="onoffswitch1">
	<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox1 changestatus" id="switch_sick{{ $i }}" data-table="event" data-field="event_status" data-id-name="id" data-id="{{ $data->id }}" {{ $status_chk }}  value="1">
	<label class="onoffswitch-label1" for="switch_sick{{ $i }}">
		<span class="onoffswitch-inner1"></span>
		<span class="onoffswitch-switch1"></span>
	</label>
	</div></td>
<td>
    <a href="{{ route('event.edit',$data['id']) }}"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;
    <a href="javascript:void(0)" data-id="{{ $data->id }}" class="data_delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
    <a href="{{ route('admin.search_event_users') }}?id=<?php echo $data->id; ?>"><i class="fa fa-user"></i></a>&nbsp;&nbsp;
    <a href="{{ route('admin.event_details') }}?id=<?php echo $data->id; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
</td>
</tr>
@php($i++)
@endforeach