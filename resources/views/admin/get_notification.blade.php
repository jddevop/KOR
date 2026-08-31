
<li>
    <div class="drop-title">You have <?php echo $noti_count; ?> new messages</div>
</li>
<li>
    <div class="message-center">
        @php($i=1)
        @foreach($noti_data as $data)
        <a href="javascript:void(0);">
            <div class="user-img">
                <?php if($data->user){ ?>
                <img src="{{ asset('upload/users/'.$data->user->profile_picture) }}" alt="user" class="img-circle">
                <?php }else{
                ?>
                <img src="{{ asset('asset/admin/plugins/images/usericn.png') }}" alt="user" class="img-circle">
                <?php
                }?>
                <span class="profile-status online pull-right"></span>
            </div>
            <div class="mail-contnet">
                <h5><?php if($data->user){ echo $data->user->first_name.' '.$data->user->last_name; } ?></h5>
                <span class="mail-desc"><?php echo $data['message']; ?></span>
                <span class="time"><?php echo date('d M, h:i A',strtotime($data['date_time'])); ?></span>
            </div>
        </a>
       @php($i++)
        @endforeach
        
    </div>
</li>
<li>
    <a class="text-center" href="{{ route('notification.index') }}">
        <strong>See all notifications</strong>
        <i class="fa fa-angle-right"></i>
    </a>
</li>
