
<?php if ($page == 'dashboard' || $page == 'myevent' || $page == 'profile' || $page == 'shifts'): ?>

    <div class="topbar burger">
        <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <img src="{{ asset('asset/images/burger.png') }}" class="img-fluid">
        </a>    
        <a href="{{ route('notifications') }}">
            <img src="{{ asset('asset/images/notification.png') }}" class="img-fluid">
        </a>
    </div>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" >
    <div class="offcanvas-header">
        <a data-bs-dismiss="offcanvas">
            <img src="{{ asset('asset/images/white-back.png') }}" class="img-fluid wh-back">
        </a>
        @if(Session::get('user_data')->profile_picture)
            <img src="{{ asset(config('global.publicpath').'upload/users/'.Session::get('user_data')->profile_picture) }}" class="img-fluid user-canvas">
        @else
		    <img src="{{ asset('asset/admin/plugins/images/users/user.png') }}"  class="img-fluid user-canvas">
		@endif
    </div>
    
    <div class="offcanvas-body">
        <div class="off-top">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('asset/images/dashboard.png') }}" class="img-fluid">
                <p>Dashboard</p>
            </a>
            <a href="{{ route('sync_status') }}">
                <img src="{{ asset('asset/images/sync.png') }}" class="img-fluid">
                <p>Sync Status & History</p>
            </a>
            <a href="{{ route('save_events') }}">
                <img src="{{ asset('asset/images/saved.png') }}" class="img-fluid">
                <p>Saved Events</p>
            </a>
            
            <a href="{{ route('settings') }}">
                <img src="{{ asset('asset/images/settings.png') }}" class="img-fluid">
                <p>Settings</p>
            </a>                                                
        </div>
        <div class="off-bot">
            <a href="{{ route('logout') }}">
                <p>Logout</p>
                <img src="{{ asset('asset/images/logout.png') }}" class="img-fluid">
            </a>  
        </div>
    </div>
    </div>
                                                                                                                    
<?php elseif ($page == 'otp' || $page == 'recover-password' || $page == 'change-password' || $page == 'shift-detail' || $page == 'annual-leave' || $page == 'request-in-review' || $page == 'no-internet' || $page == 'reset-password'): ?>

    <div class="topbar back">
        <a href="javascript:void(0)" onclick="history.back(); return false;">
            <img src="{{ asset('asset/images/back.png') }}" class="img-fluid">
        </a>
    </div>

<?php elseif ($page == 'sync-status' || $page == 'faq' || $page == 'edit-profile' || $page == 'save-event' || $page == 'upload-document' || $page == 'update-bank-detail' || $page == 'share-app' || $page == 'settings' || $page == 'notification'): ?>
    
    <div class="topbar backtitle">
        <a href="javascript:void(0)" onclick="history.back(); return false;">
            <img src="{{ asset('asset/images/back.png') }}" class="img-fluid">
        </a>
        <?php if ($page == 'sync-status'): ?>  
            <h4>Shift List & History</h4>

        <?php elseif ($page == 'save-event'): ?>  
            <h4>Save Events</h4>

        <?php elseif ($page == 'edit-profile'): ?>  
            <h4>Edit Profile</h4>
            
        <?php elseif ($page == 'upload-document'): ?>  
            <h4>Upload Document</h4>
            
        <?php elseif ($page == 'update-bank-detail'): ?>  
            <h4>Bank Account Details</h4>
            
        <?php elseif ($page == 'share-app'): ?>  
            <h4>Share App with Friend</h4>
            
        <?php elseif ($page == 'settings'): ?>  
            <h4>Settings</h4>
            
        <?php elseif ($page == 'notification'): ?>  
            <h4>Notifications</h4>  
            
        <?php elseif ($page == 'faq'): ?>  
            <h4>Help & Support</h4>              

        <?php else: ?>

        <?php endif; ?>        
       
    </div>    
    
<?php elseif ($page == 'event-detail'): ?>    

    <?php /*<div class="topbar eventback">
        <a href="javascript:void(0)" onclick="history.back(); return false;">
            <img src="{{ asset('asset/images/back.png') }}" class="img-fluid">
        </a>
        <div>
            <a href="javascript:void(0)">
                <img src="{{ asset('asset/images/save.png') }}" class="img-fluid">
            </a>
            <a href="javascript:void(0)">
                <img src="{{ asset('asset/images/share.png') }}" class="img-fluid">
            </a>                
        </div>
    </div>*/?>

<?php else: ?>



<?php endif; ?>