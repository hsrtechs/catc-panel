@extends('gentelella.layout.main')
@section('main')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Build Server <small>Create new Server</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ action('ServerController@make') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">User:</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <select name="user_id" class="select2_single form-control" tabindex="-1">
                                    @foreach(\App\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">CPU:</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <select name="cpu" class="select2_single form-control" tabindex="-1">
                                    @for($i = 1; $i <= $user->available_cpu && $i <= 16; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ram:</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <select name="ram" class="select2_single form-control" tabindex="-1">
                                    @for($i = 512; $i <= $user->available_ram && $i <= 32768; $i += 512)
                                        <option value="{{ $i }}">{{ $i }} MB</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Storage:</label>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <select name="storage" class="select2_single form-control" tabindex="-1">
                                    @for($i = 10; $i <= $user->available_storage && $i <=1000; $i += 10)
                                        <option value="{{ $i }}">{{ $i }} GB</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @if(\Session::has('build'))
        <script>
            alert("{{ \Session::get('build') }}");
        </script>
    @endif
@endsection
@section('jsa')
    <!-- Select2 -->
    <script src="/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2_single").select2({
                allowClear: true
            });
        });
    </script>
@endsection
@section('css')
    <link type="text/css" href="/css/select2.min.css" rel="stylesheet">
@endsection