<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="fa fa-bars"></i>
        </a>
        <div class="top-left-part">
            <a class="logo" href="{{ route('admin.dashboard') }}">
                <b>
                    <img src="{{ asset('asset/admin/plugins/images/logo.png') }}" alt="home" />
                </b>
                <span>
                    KOR
                </span>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li>
                <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
            </li>
            <?php /*<li>
                <form role="search" class="app-search hidden-xs">
                    <i class="icon-magnifier"></i>
                    <input type="text" placeholder="Search..." class="form-control">
                </form>
            </li>*/?>
        </ul>
        
        
        <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light font-20" data-toggle="dropdown" href="javascript:void(0);">
                            <i class="icon-speech"></i>
                            <div id="show_noti"></div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown" id="show_noti_list">
                            
                        </ul>
                    </li>
                    
                </ul>
        
    </div>
</nav>