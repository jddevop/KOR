@php($i=1)
  @foreach($view_data as $data)
<tr>
    <td id="show_td<?php echo $data->id; ?>">
     <?php if($data->current_event_status==0){ ?>
        <input type="checkbox" class="check checkfun" data-id="{{ $data->id }}" >
    <?php }else if($data->current_event_status==1){
    ?>
        <span class="label label-info">Invited</span>
    <?php }else if($data->current_event_status==3){
    ?>
        <span class="label label-danger">Applied</span>
    <?php }?>
    
    </td>
    <td>EMP-{{ $data->employee_id }}</td>
    <td>{{ $data->first_name }}</td>
    <td>{{ $data->last_name }}</td>
    <td>{{ $data->email }}</td>
    <td>{{ $data->phone }}</td>
    <td>
    <a href="{{ route('users.show',$data['id']) }}"><i class="fa fa-eye"></i></a> 
    </td>
</tr>
@php($i++)
@endforeach