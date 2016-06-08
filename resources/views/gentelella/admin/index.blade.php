@extends('gentelella.layout.main')
@section('main')
    <!-- top tiles -->
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
            <div class="count green">{{ $user->users()->count() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Admins</span>
            <div class="count green">{{ $user->getAdminsCount() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Moderators</span>
            <div class="count green">{{ $user->getModsCount() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Resellers</span>
            <div class="count green">{{ $user->getResellersCount() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Normal Users</span>
            <div class="count green">{{ $user->getNormalUsersCount() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Servers</span>
            <div class="count green">{{ $servers->all()->count() }}</div>
        </div>
    </div>
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i>Total Tickets</span>
            <div class="count {{ ($tickets->all()->count() > 0) ? 'red' : 'green' }}">{{ $tickets->all()->count() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i>Active Tickets</span>
            <div class="count {{ ($tickets->ActiveCount() > 0) ? 'red' : 'green' }}">{{ $tickets->ActiveCount() }}</div>
            <span class="count_bottom"><i class="green">{{ $tickets->AnsweredCount() }} </i> Answered, <i class="red">{{ $tickets->PendingCount() }} </i> Pending</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i>Closed Tickets</span>
            <div class="count green">{{ $tickets->ClosedCount() }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Available CPU</span>
            <div class="count @if($node->totalCpu() > 0){{ ($node->totalAvailableCpu()*100/$node->totalCpu()) < 40 ? "red" : "green" }} @else red @endif">{{ $node->totalCpu() }}</div>
            <span class="count_bottom"><i class="green">{{ $node->totalAvailableCpu() }} </i> Available</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Available Ram</span>
            <div class="count @if($node->totalRam() > 0){{ ($node->totalAvailableRam()*100/$node->totalRam()) < 40 ? "red" : "green" }} @else red @endif">{{ $node->totalRam() }}</div>
            <span class="count_bottom"><i class="green">{{ $node->totalAvailableRam() }} </i> Available</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-scan"></i> Total Available Storage</span>
            <div class="count @if($node->totalStorage() > 0){{ ($node->totalAvailableStorage()*100/$node->totalStorage()) < 40 ? "red" : "green" }} @else red @endif">{{ $node->totalStorage() }}</div>
            <span class="count_bottom"><i class="green">{{ $node->totalAvailableStorage() }} </i> Available</span>
        </div>
    </div>
    <!-- /top tiles -->
    <div class="row">
        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Users
                        <small>Logs</small>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <article class="media event">
                        <a class="pull-left date">
                            <p class="month">April</p>
                            <p class="day">23</p>
                        </a>
                        <div class="media-body">
                            <a class="title" href="#">Item One Title</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Server
                        <small>Logs</small>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <article class="media event">
                        <a class="pull-left date">
                            <p class="month">April</p>
                            <p class="day">23</p>
                        </a>
                        <div class="media-body">
                            <a class="title" href="#">Item One Title</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Server
                        <small>Logs</small>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <article class="media event">
                        <a class="pull-left date">
                            <p class="month">April</p>
                            <p class="day">23</p>
                        </a>
                        <div class="media-body">
                            <a class="title" href="#">Item One Title</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
@endsection