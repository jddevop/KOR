<?php if ($page != 'shift-detail' && $page != 'sync-status' && $page != 'save-event' && $page != 'annual-leave' && $page != 'settings' && $page != 'change-password' && $page != 'event-detail' && $page != 'faq' && $page != 'notification' && $page != 'request-in-review' && $page != 'share-app' && $page != 'update-bank-detail' && $page != 'upload-document' && $page != 'edit-profile'){ ?> 
<div class="footer">
    <div class="">
        <a href="{{ route('dashboard') }}" class="<?= ($page == 'dashboard') ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 7.99309V9.66669C2 11.8666 2 12.9665 2.68342 13.65C3.36683 14.3334 4.46678 14.3334 6.66667 14.3334H9.33333C11.5332 14.3334 12.6331 14.3334 13.3166 13.65C14 12.9665 14 11.8666 14 9.66669V7.99309C14 6.87222 14 6.31184 13.7627 5.82672C13.5255 5.3416 13.0831 4.99754 12.1984 4.30943L10.8651 3.27239C9.48873 2.20192 8.8006 1.66669 8 1.66669C7.1994 1.66669 6.51126 2.20192 5.13495 3.27239L3.80161 4.30943C2.91689 4.99754 2.47453 5.3416 2.23727 5.82672C2 6.31184 2 6.87222 2 7.99309Z" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.0001 11.3333C9.46714 11.7482 8.76694 12 8.00014 12C7.23327 12 6.53314 11.7482 6.00012 11.3333" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>            
            <span>Home</span>
        </a>        
    </div>
    <div class="">
        <a href="{{ route('shifts') }}" class="<?= ($page == 'shifts') ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.00001 14.6667C11.6819 14.6667 14.6667 11.6819 14.6667 8.00004C14.6667 4.31814 11.6819 1.33337 8.00001 1.33337C4.31811 1.33337 1.33334 4.31814 1.33334 8.00004C1.33334 11.6819 4.31811 14.6667 8.00001 14.6667Z" stroke="#FFFFFF80"/>
                <path d="M8 5.33337V8.00004L9.33333 9.33337" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>            
            <span>Shifts</span>
        </a>
    </div>
    <div class="">
        <a href="{{ route('my_events') }}" class="<?= ($page == 'myevent') ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.6666 1.33337V4.00004M5.33331 1.33337V4.00004" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.66667 2.66663H7.33333C4.81917 2.66663 3.5621 2.66663 2.78105 3.44767C2 4.22873 2 5.4858 2 7.99996V9.33329C2 11.8474 2 13.1046 2.78105 13.8856C3.5621 14.6666 4.81917 14.6666 7.33333 14.6666H8.66667C11.1808 14.6666 12.4379 14.6666 13.2189 13.8856C14 13.1046 14 11.8474 14 9.33329V7.99996C14 5.4858 14 4.22873 13.2189 3.44767C12.4379 2.66663 11.1808 2.66663 8.66667 2.66663Z" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 6.66663H14" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.3333 10.3333V11.6667M11.3333 11C11.3333 11.5523 10.8856 12 10.3333 12C9.78105 12 9.33331 11.5523 9.33331 11C9.33331 10.4477 9.78105 10 10.3333 10C10.8856 10 11.3333 10.4477 11.3333 11Z" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>            
            <span>My Events</span>
        </a>
    </div>
    <div class="">
        <a href="{{ route('profile') }}" class="<?= ($page == 'profile') ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.3334 5.66671C11.3334 3.82576 9.84095 2.33337 8.00002 2.33337C6.15907 2.33337 4.66669 3.82576 4.66669 5.66671C4.66669 7.50764 6.15907 9.00004 8.00002 9.00004C9.84095 9.00004 11.3334 7.50764 11.3334 5.66671Z" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12.6666 13.6667C12.6666 11.0893 10.5773 9 7.99998 9C5.42265 9 3.33331 11.0893 3.33331 13.6667" stroke="#FFFFFF80" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>            
            <span>Profile</span>
        </a>
    </div>
</div>
<?php }?>