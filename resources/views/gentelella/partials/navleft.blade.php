<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('theme::home') }}" class="site_title"><i class="fa fa-star"></i>
                <span>HSR Panel</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="/images/img.jpg" alt="Profile Picture for {{$user->name}}" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{$user->name}}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>{{$user->role->name}}</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ action('UserController@Dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="navbar-heading">
                        <h3>Manage Cloud</h3>
                    </li>
                    <li>
                        <a><i class="fa fa-plus"></i> Build VPS</a>
                    </li>
                    <li>
                        <a href="{{ action('ServerController@listServers') }}"><i class="fa fa-wrench"></i> Manage
                            Servers</a>
                    </li>
                    <li class="navbar-heading">
                        <h3>Support Section</h3>
                    </li>
                    <li>
                        <a><i class="fa fa-edit"></i> Create Ticket</a>
                    </li>
                    <li>
                        <a><i class="fa fa-mail-reply-all"></i> Active Tickets</a>
                    </li>
                    <li>
                        <a><i class="fa fa-thumbs-up"></i> Closed Ticket</a>
                    </li>
                    <li class="navbar-heading">
                        <h3>Account Section</h3>
                    </li>
                    <li>
                        <a href="{{ action('UserController@Profile',['user' => $user->username]) }}"><i
                                    class="fa fa-table"></i> Profile </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings" href="{{ route('theme::settings') }}">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>