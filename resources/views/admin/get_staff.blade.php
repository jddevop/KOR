@php($i=1)
  @foreach($staff_data as $data)
    <tr>
        <td><input type="checkbox" class="check checkfun" name="assign_staff[]" value="<?php echo $data['id']; ?>" <?php echo $data['cheked_status'] ? 'checked' : ''; ?> data-id="{{ $data['id'] }}"></td>
        <td>EMP-<?php echo $data['employee_id']; ?></td>
        <td><?php echo $data['first_name']; ?></td>
        <td><?php echo $data['last_name']; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td>+<?php echo $data['country_code']; ?> <?php echo $data['phone']; ?></td>
        
        <td>
            <?php if($data['tags_id']!=''){  
                $tags_arr=get_users_tags($data['tags_id']);
                foreach($tags_arr as $key=>$val){
            ?>
                <span class="single-tag" style="background-color:<?php echo $val['color']; ?>;"><?php echo $val['name']; ?></span> 
            <?php } }?>
           
        </td>
    </tr>
@php($i++)
@endforeach