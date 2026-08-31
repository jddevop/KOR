<aside class="sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div class="profile-image">
                    @if(Session::get('admin_data')->image)
    				    <img src="{{ asset(config('global.publicpath').'upload/admin/'.Session::get('admin_data')->image) }}" alt="user_auth" class="img-circle">
    				@else
    				    <img src="{{ asset('asset/admin/plugins/images/users/user.png') }}" alt="user_auth" class="img-circle">
    				@endif
                    
                    <a href="javascript:void(0);" class="dropdown-toggle u-dropdown text-blue" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="badge badge-danger">
                            <i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated flipInY">
                        <li><a href="{{ route('admin.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
                        
                        <li><a href="{{ route('admin.change_password') }}"><i class="fa fa-user"></i> Change Password</a></li>
                        
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('admin.logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </div>
                <p class="profile-text m-t-15 font-16"><a href="javascript:void(0);"> @if(Session::get('admin_data')->name) {{ Session::get('admin_data')->name }}@endif</a></p>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul id="side-menu">
                
                <li class="@if($main_menu=='dashboard') active @endif">
                    <a  href="{{ route('admin.dashboard') }}" aria-expanded="false" class="@if($main_menu=='dashboard') active @endif"><i class="icon-screen-desktop fa-fw"></i> <span class="hide-menu"> Dashboard </span></a>
                    
                </li>
                <li class="@if($main_menu=='users') active @endif">
                    <a  href="{{ route('users.index') }}" aria-expanded="false" class="@if($main_menu=='users') active @endif"><i class="icon-user fa-fw"></i> <span class="hide-menu"> Manage Users </span></a>
                    
                </li>
                <li class="@if($main_menu=='settings') active @endif">
                    <a class="waves-effect" href="javascript:void(0);" aria-expanded="@if($main_menu=='settings') true  @else false @endif"><i class="icon-settings fa-fw"></i> <span class="hide-menu"> Settings <span class="label label-rounded label-primary pull-right">8</span></span></a>
                    <ul aria-expanded="@if($main_menu=='settings') true  @else false @endif" class="collapse @if($main_menu=='settings') in @endif">
                        <li class="@if($sub_menu=='tags') active @endif"> <a href="{{ route('tags.index') }}" class="@if($sub_menu=='tags') active @endif">Manage Tags</a> </li>
                        <li class="@if($sub_menu=='english_level') active @endif"> <a href="{{ route('english_level.index') }}" class="@if($sub_menu=='english_level') active @endif">Manage English Level</a> </li>
                        <li class="@if($sub_menu=='occupations') active @endif"> <a href="{{ route('occupations.index') }}" class="@if($sub_menu=='occupations') active @endif">Manage Occupations</a> </li>
                        <li class="@if($sub_menu=='city') active @endif"> <a href="{{ route('city.index') }}" class="@if($sub_menu=='city') active @endif">Manage City</a> </li>
                        <li class="@if($sub_menu=='experience_level') active @endif"> <a href="{{ route('experience_level.index') }}" class="@if($sub_menu=='experience_level') active @endif">Manage Experience Level</a> </li>
                        <li class="@if($sub_menu=='employer') active @endif"> <a href="{{ route('employer.index') }}" class="@if($sub_menu=='employer') active @endif">Manage Employer</a> </li>
                        <li class="@if($sub_menu=='support_number') active @endif"> <a href="{{ route('support_number.index') }}" class="@if($sub_menu=='support_number') active @endif">Manage Support Number</a> </li>
                        <li class="@if($sub_menu=='annual_leave') active @endif"> <a href="{{ route('annual_leave.index') }}" class="@if($sub_menu=='annual_leave') active @endif">Manage Annual Leave</a> </li>
                    </ul>
                </li>
                
                
                
                
                <li class="@if($main_menu=='event') active @endif">
                    <a class="waves-effect" href="javascript:void(0);" aria-expanded="@if($main_menu=='event') true  @else false @endif"><i class="icon-calender fa-fw"></i> <span class="hide-menu"> Manage Event <span class="label label-rounded label-primary pull-right">2</span></span></a>
                    <ul aria-expanded="@if($main_menu=='event') true  @else false @endif" class="collapse @if($main_menu=='event') in @endif">
                        <li class="@if($sub_menu=='event') active @endif"> <a href="{{ route('event.index') }}" class="@if($sub_menu=='event') active @endif">Manage Event</a> </li>
                        <li class="@if($sub_menu=='event_history') active @endif"> <a href="{{ route('event_history.index') }}" class="@if($sub_menu=='event_history') active @endif">Manage Past Event</a> </li>
                    </ul>
                </li>
                <li class="@if($main_menu=='clock_data') active @endif">
                    <a  href="{{ route('clock_data.index') }}" aria-expanded="false" class="@if($main_menu=='clock_data') active @endif"><i class="icon-wallet fa-fw"></i> <span class="hide-menu"> Manage Clock Data </span></a>
                    
                </li>  
                <li class="@if($main_menu=='payroll') active @endif">
                    <a  href="{{ route('payroll.index') }}" aria-expanded="false" class="@if($main_menu=='payroll') active @endif"><i class="icon-wallet fa-fw"></i> <span class="hide-menu"> Manage Payroll </span></a>
                    
                </li>  
                
                     
                
                
        	
        	
            
        	<li class="@if($main_menu=='help_support') active @endif">
                    <a  href="{{ route('help_support.index') }}" aria-expanded="false" class="@if($main_menu=='help_support') active @endif"><i class="ti-help fa-fw"></i> <span class="hide-menu"> Manage Help & Support </span></a>
            </li>
            
            <li class="@if($main_menu=='terms_of_employment') active @endif">
                    <a  href="{{ route('terms_of_employment.index') }}" aria-expanded="false" class="@if($main_menu=='terms_of_employment') active @endif"><i class="ti-agenda fa-fw"></i> <span class="hide-menu"> Terms of Employment </span></a>
            </li>
                
                <li >
                    <a href="{{ route('admin.logout') }}" aria-expanded="false"><i class="icon-power fa-fw"></i> <span class="hide-menu">Logout</span></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>