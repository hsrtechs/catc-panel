@extends('gentelella.layout.main')
@section('main')
    <div class="">
        <div class="row">
            @include('gentelella.partials.page-tittle',['heading'=> 'Servers','small' => 'list'])
            <div class="col-md-12">
                @if(count($servers))
                    @foreach($servers as $server)
                        <div class="x_panel" style="min-height: inherit">
                            <div class="x_title">
                                <h2><strong>Server Label:</strong> {{ $server->label }}</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- start project list -->
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%">#</th>
                                        <th style="width: 20%">Server Label</th>
                                        <th>Information</th>
                                        <th>Resources</th>
                                        <th>Status</th>
                                        <th style="width: 20%">#Manage</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>{{ $server->id }}</td>
                                        <td>
                                            <a>{{ $server->label }}</a>
                                            <br/>
                                            <small>{{ $server->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <ul id="data-list">
                                                <li>IP: {{ ($server->ip) }}</li>
                                                <li>CPU: {{ $server->cpu }}</li>
                                                <li>Ram: {{ $server->ram }}</li>
                                                <li>Storage: {{ $server->storage }}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-{{ ($server->used_cpu[0] < 50) ? 'success': 'danger' }} btn-xs" style="width: 100%;">CPU</button>
                                            <br/>
                                            <button type="button" class="btn btn-{{ ($server->used_ram[0] < 60) ? 'success': 'danger' }} btn-xs" style="width: 100%; margin-top: 10px">RAM</button>
                                            <br/>
                                            <button type="button" class="btn btn-{{ ($server->used_storage[0] < 70) ? 'success': 'danger' }} btn-xs" style="width: 100%; margin-top: 10px">Storage</button>
                                            <br/>
                                        </td>
                                        <td class="project_progress">
                                            <div class="progress progress_sm">
                                                <div class="progress-bar bg-{{ ($server->used_cpu[0] < 50) ? 'green': 'red' }}" role="progressbar" data-transitiongoal="{{ $server->used_cpu[0] }}"></div>
                                            </div>
                                            <small>{{ $server->used_cpu[0] }}% Used</small>
                                            <div class="progress progress_sm">
                                                <div class="progress-bar bg-{{ ($server->used_ram[0] < 60) ? 'green': 'red' }}" role="progressbar" data-transitiongoal="{{ $server->used_ram[0] }}"></div>
                                            </div>
                                            <small>{{ $server->used_ram[0] }}% Used</small>
                                            <div class="progress progress_sm">
                                                <div class="progress-bar bg-{{ ($server->used_storage[0] < 70) ? 'green': 'red' }}" role="progressbar" data-transitiongoal="{{ $server->used_storage[0] }}"></div>
                                            </div>
                                            <small>{{ $server->used_storage[0] }}% Used</small>
                                        </td>
                                        <td>
                                            <a href="{{ action("ServerController@serverView",['id'=>$server->id]) }}" class="btn btn-info btn-xs" style="width: 100%; margin-top: 10px;"><i class="fa fa-pencil"></i> Edit </a><br/>
                                            <a href="{{ action('ServerController@changeServerOwner',['id' => $server->id]) }}" class="btn btn-primary btn-xs" style="width: 100%; margin-top: 10px;"><i class="fa fa-pencil"></i> Change Server Owner </a><br/>
                                            <a href="{{ action('ServerController@delete',['id' => $server->id]) }}" class="btn btn-danger btn-xs" style="width: 100%; margin-top: 10px;"><i class="fa fa-trash-o"></i> Delete </a><br/>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <!-- end project list -->

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="well">
                        No Servers Found.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- bootstrap-progressbar -->
    <script src="/js/bootstrap-progressbar.min.js"></script>
@endsection