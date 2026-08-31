@php($i=1)
  @foreach($view_data as $data)
<tr >
   
    <td>EMP-{{ $data->employee_id }}</td>
    <td>{{ $data->first_name }}</td>
    <td>{{ $data->last_name }}</td>
    <td>{{ $data->email }}</td>
    <td>+{{ $data->country_code }} {{ $data->phone }}</td>
    
    <td>
    <?php if($data->tags_id!=''){  
        $tags_arr=get_users_tags($data->tags_id);
        foreach($tags_arr as $key=>$val){
    ?>
        <span class="single-tag" style="background-color:<?php echo $val['color']; ?>;"><?php echo $val['name']; ?></span> 
    <?php } }?>
    </td>
    <td><?php echo $data->pps_number; ?></td>
    <td><?php $bank=get_users_bank_detail($data->id); echo str_replace(' ', '', $bank); ?></td>
    <td><?php echo substr($bank, 8,6);?></td>
    <td><?php echo substr($bank, 14); ?></td>
    <td>@php($status_chk='')
	@if ($data->status == 1)
		@php($status_chk='checked="checked"')
	@endif
		<div class="onoffswitch" >
		<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox changestatus" id="switch_sick{{ $i }}" data-table="users" data-field="status" data-id-name="id" data-id="{{ $data->id }}" {{ $status_chk }}  value="1">
		<label class="onoffswitch-label" for="switch_sick{{ $i }}">
			<span class="onoffswitch-inner"></span>
			<span class="onoffswitch-switch"></span>
		</label>
		</div></td>
	<td><a href="https://web.whatsapp.com/send?phone={{ $data['country_code'].$data['phone'] }}" target="_blank" > <img src="{{ asset('asset/admin/images/whatsap.png') }}" alt="loader"/></a></td>
    <td style="min-width: 145px;">
        <a href="javascript:void(0)" data-id="{{ $data->id }}" class="data_delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ route('users.show',$data['id']) }}"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp; 
        <a href="javascript:void(0)" onclick="add_users_tags('<?php echo $data->id; ?>')"> Add Tags</a>&nbsp;&nbsp;&nbsp;&nbsp;
         
    </td>
</tr>
@php($i++)
@endforeach