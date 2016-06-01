@extends('gentelella.layout.main')
@section('main')
    <!-- page content -->
    <div class="">
        @include('gentelella.partials.page-tittle',['heading' => $user->name.'\'s','small' => 'Profile' ])
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">

                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                            <div class="profile_img">

                                <!-- end of image cropping -->
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <a>
                                        <img class="img-responsive avatar-view" src="/images/img.jpg" alt="Avatar"
                                             title="Change the avatar">
                                    </a>

                                </div>
                                <!-- end of image cropping -->

                            </div>
                            <h3>{{ $user->name }}</h3>

                            <ul class="list-unstyled user_data">
                                <li>
                                    <i class="fa fa-map-marker user-profile-icon"></i>
                                    Joined: {{ $user->created_at->diffForHumans() }}
                                </li>

                                <li class="green">
                                    <i class="fa fa-briefcase user-profile-icon"></i> {{ strtoupper($user->role->name) }}
                                </li>
                            </ul>

                            <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                            <br/>

                            <!-- start skills -->
                            <h4>Skills</h4>
                            <ul class="list-unstyled user_data">
                                <li>
                                    <p>CPU</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-{{ ($user->cpu_percentage > 40) ? 'green' : 'red' }}"
                                             role="progressbar" data-transitiongoal="{{ $user->cpu_percentage }}"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>RAM</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-{{ ($user->ram_percentage > 40) ? 'green' : 'red' }}"
                                             role="progressbar" data-transitiongoal="{{ $user->ram_percentage }}"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>Storage</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-{{ ($user->storage_percentage > 40) ? 'green' : 'red' }}"
                                             role="progressbar"
                                             data-transitiongoal="{{ $user->storage_percentage }}"></div>
                                    </div>
                                </li>
                            </ul>
                            <!-- end of skills -->

                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab"
                                           aria-expanded="true">Recent Activity</a>
                                    </li>
                                    <li role="presentation" class="">
                                        <a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"
                                           aria-expanded="false">Projects Worked on</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1"
                                         aria-labelledby="home-tab">
                                        <!-- start recent activity -->
                                        <ul class="messages">
                                            <li>
                                                <img src="/images/img.jpg" class="avatar" alt="Avatar">
                                                <div class="message_date">
                                                    <h3 class="date text-info">24</h3>
                                                    <p class="month">May</p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">Desmond Davison</h4>
                                                    <blockquote class="message">Raw denim you probably haven't heard of
                                                        them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher
                                                        retro keffiyeh dreamcatcher synth.
                                                    </blockquote>
                                                    <br/>
                                                    <p class="url">
                                                        <span class="fs1 text-info" aria-hidden="true"
                                                              data-icon=""></span>
                                                        <a href="#"><i class="fa fa-paperclip"></i> User Acceptance
                                                            Test.doc </a>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- end recent activity -->

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2"
                                         aria-labelledby="profile-tab">

                                        <!-- start user projects -->
                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project Name</th>
                                                <th>Client Company</th>
                                                <th class="hidden-phone">Hours Spent</th>
                                                <th>Contribution</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>New Company Takeover Review</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">18</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success"
                                                             data-transitiongoal="35"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!-- end user projects -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- bootstrap-progressbar -->
    <script src="/js/bootstrap-progressbar.min.js"></script>
@endsection